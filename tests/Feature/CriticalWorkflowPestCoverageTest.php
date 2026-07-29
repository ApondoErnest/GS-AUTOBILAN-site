<?php

use App\Data\TrackingResult;
use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use App\Services\BookingService;
use App\Services\TrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\RateLimiter;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

afterEach(function () {
    Carbon::setTestNow();
});

it('keeps S084 booking references unique when sequence state trails existing bookings', function () {
    Carbon::setTestNow('2026-07-29 09:00:00');
    [$agency, $inspectionService] = s084OperationalDependencies();

    Booking::query()->create([
        ...s084BookingAttributes($agency, $inspectionService, 'CE084AA', '+237699084000'),
        'reference' => 'GS-2026-000005',
        'status' => BookingStatus::NewRequest,
    ]);

    Setting::query()->create([
        'key' => 'booking_reference_sequence_2026',
        'value' => [
            'year' => 2026,
            'last' => 2,
        ],
    ]);

    $first = app(BookingService::class)->create(s084BookingPayload($agency, $inspectionService, 'CE084AB', '+237699084001'));
    $second = app(BookingService::class)->create(s084BookingPayload($agency, $inspectionService, 'CE084AC', '+237699084002'));

    expect($first->reference)->toBe('GS-2026-000006');
    expect($second->reference)->toBe('GS-2026-000007');
    expect(Booking::query()->pluck('reference')->duplicates()->isEmpty())->toBeTrue();
    expect(DocumentReadiness::query()->whereIn('booking_id', [$first->id, $second->id])->count())->toBe(2);
    expect(Setting::query()->where('key', 'booking_reference_sequence_2026')->firstOrFail()->value)
        ->toBe([
            'year' => 2026,
            'last' => 7,
        ]);
});

it('tracks S084 requests only when reference phone and plate all match', function () {
    Carbon::setTestNow('2026-07-29 09:00:00');
    [$agency, $inspectionService] = s084OperationalDependencies();
    $booking = app(BookingService::class)->create(s084BookingPayload($agency, $inspectionService, 'CE084AB', '+237699084001'));

    $booking->update([
        'status' => BookingStatus::Confirmed,
        'confirmed_date' => '2026-08-01',
        'confirmed_time_slot' => '10h00-11h00',
        'internal_notes' => 'S084 internal scheduling note',
        'public_message' => 'Your appointment is confirmed.',
    ]);
    $booking->documentReadiness()->update([
        'status' => DocumentReadinessStatus::ReadyForVisit,
        'missing_information_note' => 'S084 private document note',
        'next_action_fr' => 'Presentez-vous avec vos documents originaux.',
        'next_action_en' => 'Please bring your original documents.',
        'public_message_fr' => 'Votre dossier est pret.',
        'public_message_en' => 'Your document file is ready.',
    ]);

    $result = app(TrackingService::class)->lookup(
        reference: ' '.strtolower($booking->reference).' ',
        phone: '+237 699 084 001',
        vehicleRegistration: ' ce 084 ab ',
    );

    expect($result)->toBeInstanceOf(TrackingResult::class);
    expect($result->reference)->toBe($booking->reference);
    expect($result->bookingStatus)->toBe(BookingStatus::Confirmed);
    expect($result->documentReadinessStatus)->toBe(DocumentReadinessStatus::ReadyForVisit);

    RateLimiter::clear('tracking-lookup|127.0.0.1');

    $this->post('/en/appointment-tracking', [
        'reference' => ' '.strtolower($booking->reference).' ',
        'phone' => '+237 699 084 001',
        'vehicle_registration' => ' ce 084 ab ',
    ])
        ->assertOk()
        ->assertSee('data-tracking-result', false)
        ->assertSee($booking->reference, false)
        ->assertSee('Confirmed', false)
        ->assertSee('Ready for visit', false)
        ->assertSee('Please bring your original documents.', false)
        ->assertSee('Your appointment is confirmed.', false)
        ->assertSee('Your document file is ready.', false)
        ->assertDontSee('Client S084', false)
        ->assertDontSee('client-s084@example.test', false)
        ->assertDontSee('S084 internal scheduling note', false)
        ->assertDontSee('S084 private document note', false);

    $this->from('/en/appointment-tracking')
        ->post('/en/appointment-tracking', [
            'reference' => $booking->reference,
            'phone' => '+237699084999',
            'vehicle_registration' => $booking->vehicle_registration,
        ])
        ->assertRedirect('/en/appointment-tracking')
        ->assertSessionHasErrors('tracking_lookup');
});

it('enforces S084 booking and document-readiness authorization by staff role', function () {
    [$agency, $inspectionService] = s084OperationalDependencies('nkolbisson', 1);
    [$otherAgency] = s084OperationalDependencies('obili-scalom', 2);
    $booking = app(BookingService::class)->create(s084BookingPayload($agency, $inspectionService, 'CE084AB', '+237699084001'));
    $otherBooking = app(BookingService::class)->create(s084BookingPayload($otherAgency, $inspectionService, 'CE084AC', '+237699084002'));
    $documentReadiness = $booking->documentReadiness;
    $otherDocumentReadiness = $otherBooking->documentReadiness;

    $superAdmin = s084StaffUser('super_admin');
    $agencyAdmin = s084StaffUser('agency_admin', $agency);
    $unassignedAgencyAdmin = s084StaffUser('agency_admin');
    $contentManager = s084StaffUser('content_manager');

    expect($superAdmin->can('viewAny', Booking::class))->toBeTrue();
    expect($superAdmin->can('update', $booking))->toBeTrue();
    expect($superAdmin->can('update', $otherDocumentReadiness))->toBeTrue();

    expect($agencyAdmin->can('viewAny', Booking::class))->toBeTrue();
    expect($agencyAdmin->can('create', Booking::class))->toBeTrue();
    expect($agencyAdmin->can('view', $booking))->toBeTrue();
    expect($agencyAdmin->can('update', $booking))->toBeTrue();
    expect($agencyAdmin->can('delete', $booking))->toBeFalse();
    expect($agencyAdmin->can('view', $documentReadiness))->toBeTrue();
    expect($agencyAdmin->can('update', $documentReadiness))->toBeTrue();
    expect($agencyAdmin->can('view', $otherBooking))->toBeFalse();
    expect($agencyAdmin->can('update', $otherBooking))->toBeFalse();
    expect($agencyAdmin->can('view', $otherDocumentReadiness))->toBeFalse();
    expect($agencyAdmin->can('update', $otherDocumentReadiness))->toBeFalse();

    expect($unassignedAgencyAdmin->can('viewAny', Booking::class))->toBeFalse();
    expect($unassignedAgencyAdmin->can('create', Booking::class))->toBeFalse();
    expect($unassignedAgencyAdmin->can('view', $booking))->toBeFalse();
    expect($unassignedAgencyAdmin->can('update', $documentReadiness))->toBeFalse();

    expect($contentManager->can('viewAny', Booking::class))->toBeFalse();
    expect($contentManager->can('update', $booking))->toBeFalse();
    expect($contentManager->can('update', $documentReadiness))->toBeFalse();
});

/**
 * @return array{Agency, Service}
 */
function s084OperationalDependencies(string $agencySlug = 'nkolbisson', int $sortOrder = 1): array
{
    $agency = Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($agencySlug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($agencySlug)->headline(),
        'slug' => $agencySlug,
        'address_fr' => 'Carrefour Onana',
        'address_en' => 'Onana junction',
        'city' => 'Yaounde',
        'quarter' => str($agencySlug)->headline(),
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => $agencySlug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'map_link' => 'https://www.google.com/maps?q=3.8882487,11.4549352',
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);

    $inspectionService = Service::query()->firstOrCreate(
        ['slug_fr' => 'vehicules-legers'],
        [
            'title_fr' => 'Vehicules legers',
            'title_en' => 'Light vehicles',
            'slug_en' => 'light-vehicles',
            'short_description_fr' => 'Controle technique pour voitures particulieres.',
            'short_description_en' => 'Technical inspection for passenger cars.',
            'sort_order' => 1,
            'is_active' => true,
        ],
    );

    return [$agency, $inspectionService];
}

/**
 * @return array<string, mixed>
 */
function s084BookingPayload(Agency $agency, Service $inspectionService, string $registration, string $phone): array
{
    return s084BookingAttributes($agency, $inspectionService, $registration, $phone);
}

/**
 * @return array<string, mixed>
 */
function s084BookingAttributes(Agency $agency, Service $inspectionService, string $registration, string $phone): array
{
    return [
        'customer_name' => 'Client S084',
        'phone' => $phone,
        'whatsapp' => $phone,
        'email' => 'client-s084@example.test',
        'agency_id' => $agency->id,
        'service_id' => $inspectionService->id,
        'vehicle_registration' => $registration,
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-30',
        'preferred_time_slot' => '09h00-10h00',
        'customer_message' => 'S084 regression request.',
    ];
}

function s084StaffUser(string $role, ?Agency $agency = null): User
{
    $user = User::query()->create([
        'name' => str($role)->replace('_', ' ')->title(),
        'email' => $role.'-s084-'.str()->uuid().'@example.test',
        'password' => 'password',
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
