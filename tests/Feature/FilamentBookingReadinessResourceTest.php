<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookingResource\Pages\CreateBooking;
use App\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Filament\Resources\DocumentReadinessResource;
use App\Filament\Resources\DocumentReadinessResource\Pages\CreateDocumentReadiness;
use App\Filament\Resources\DocumentReadinessResource\Pages\EditDocumentReadiness;
use App\Filament\Resources\DocumentReadinessResource\Pages\ListDocumentReadiness;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

it('registers the S053 booking and document readiness resources on the admin panel', function () {
    expect(Filament::getPanel('admin')->getResources())
        ->toContain(
            BookingResource::class,
            DocumentReadinessResource::class,
        );
});

it('allows super admins to create bookings and update operational statuses', function () {
    $agency = s053Agency('nkolbisson', 1);
    $service = s053Service('light-vehicles');
    $superAdmin = s053User('super_admin');

    s053ActingAs($superAdmin);

    Livewire::test(CreateBooking::class)
        ->fillForm(s053BookingPayload($agency, $service))
        ->call('create')
        ->assertHasNoFormErrors();

    $booking = Booking::query()->where('customer_name', 'Client S053')->firstOrFail();

    expect($booking->reference)->toStartWith('GS-')
        ->and($booking->status)->toBe(BookingStatus::NewRequest)
        ->and($booking->documentReadiness)->toBeInstanceOf(DocumentReadiness::class)
        ->and($booking->documentReadiness->status)->toBe(DocumentReadinessStatus::NotReviewed);

    Livewire::test(ListBookings::class)
        ->assertCanSeeTableRecords([$booking])
        ->assertTableColumnFormattedStateSet('status', 'New request', $booking);

    Livewire::test(EditBooking::class, ['record' => $booking->id])
        ->fillForm([
            'status' => BookingStatus::Confirmed->value,
            'confirmed_date' => '2026-07-24',
            'confirmed_time_slot' => '10h00-11h00',
            'public_message' => 'Votre rendez-vous est confirme.',
            'internal_notes' => 'Client appele par la direction.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $booking = $booking->fresh();

    expect($booking)
        ->status->toBe(BookingStatus::Confirmed)
        ->confirmed_time_slot->toBe('10h00-11h00')
        ->public_message->toBe('Votre rendez-vous est confirme.')
        ->internal_notes->toBe('Client appele par la direction.');

    $documentReadiness = $booking->documentReadiness()->firstOrFail();

    Livewire::test(EditDocumentReadiness::class, ['record' => $documentReadiness->id])
        ->fillForm([
            'status' => DocumentReadinessStatus::MissingInfo->value,
            'missing_information_note' => 'Copie CNI manquante.',
            'next_action_fr' => 'Envoyer la copie CNI avant la visite.',
            'next_action_en' => 'Send the ID copy before the visit.',
            'public_message_fr' => 'Votre dossier est incomplet.',
            'public_message_en' => 'Your file is incomplete.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($documentReadiness->fresh())
        ->status->toBe(DocumentReadinessStatus::MissingInfo)
        ->missing_information_note->toBe('Copie CNI manquante.')
        ->updated_by->toBe($superAdmin->id);
});

it('allows creating document readiness records for bookings missing a review row', function () {
    $agency = s053Agency('obili-scalom', 1);
    $service = s053Service('utility-vehicles');
    $booking = s053Booking($agency, $service, 'GS-2026-053777', BookingStatus::PendingConfirmation);

    s053ActingAs(s053User('super_admin'));

    Livewire::test(CreateDocumentReadiness::class)
        ->fillForm([
            'booking_id' => $booking->id,
            'status' => DocumentReadinessStatus::Complete->value,
            'public_message_fr' => 'Dossier complet.',
            'public_message_en' => 'File complete.',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect($booking->fresh()->documentReadiness)
        ->status->toBe(DocumentReadinessStatus::Complete);
});

it('scopes agency admins to their assigned booking and readiness records', function () {
    $agency = s053Agency('nkolbisson', 1);
    $otherAgency = s053Agency('obili-scalom', 2);
    $service = s053Service('light-vehicles');
    $booking = s053Booking($agency, $service, 'GS-2026-053001', BookingStatus::NewRequest);
    $otherBooking = s053Booking($otherAgency, $service, 'GS-2026-053002', BookingStatus::Confirmed);
    $documentReadiness = s053DocumentReadiness($booking, DocumentReadinessStatus::NotReviewed);
    $otherDocumentReadiness = s053DocumentReadiness($otherBooking, DocumentReadinessStatus::ReadyForVisit);

    s053ActingAs(s053User('agency_admin', $agency));

    $this->get('/admin/bookings')->assertOk();
    $this->get('/admin/bookings/create')->assertOk();
    $this->get("/admin/bookings/{$booking->id}/edit")->assertOk();
    $this->get("/admin/bookings/{$otherBooking->id}/edit")->assertNotFound();

    expect(BookingResource::getEloquentQuery()->pluck('id')->all())
        ->toBe([$booking->id])
        ->not->toContain($otherBooking->id);

    Livewire::test(ListBookings::class)
        ->assertCanSeeTableRecords([$booking])
        ->assertCanNotSeeTableRecords([$otherBooking]);

    $this->get('/admin/document-readiness')->assertOk();
    $this->get("/admin/document-readiness/{$documentReadiness->id}/edit")->assertOk();
    $this->get("/admin/document-readiness/{$otherDocumentReadiness->id}/edit")->assertNotFound();

    expect(DocumentReadinessResource::getEloquentQuery()->pluck('id')->all())
        ->toBe([$documentReadiness->id])
        ->not->toContain($otherDocumentReadiness->id);

    Livewire::test(ListDocumentReadiness::class)
        ->assertCanSeeTableRecords([$documentReadiness])
        ->assertCanNotSeeTableRecords([$otherDocumentReadiness]);

    Livewire::test(EditBooking::class, ['record' => $booking->id])
        ->fillForm([
            'status' => BookingStatus::PendingConfirmation->value,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($booking->fresh())
        ->agency_id->toBe($agency->id)
        ->status->toBe(BookingStatus::PendingConfirmation);
});

it('keeps booking and readiness resources unavailable to content managers and unassigned agency admins', function (string $role) {
    s053ActingAs(s053User($role));

    expect(BookingResource::canAccess())->toBeFalse();
    expect(DocumentReadinessResource::canAccess())->toBeFalse();

    $this->get('/admin/bookings')->assertForbidden();
    $this->get('/admin/document-readiness')->assertForbidden();
})->with([
    'content_manager',
    'agency_admin',
]);

function s053ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s053User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s053Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678000001'],
        'whatsapp' => '+237678000001',
        'email' => $slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s053Service(string $slug): Service
{
    return Service::query()->create([
        'title_fr' => 'Vehicules legers '.$slug,
        'title_en' => 'Light vehicles '.$slug,
        'slug_fr' => 'vehicules-legers-'.$slug,
        'slug_en' => 'light-vehicles-'.$slug,
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

/**
 * @return array<string, mixed>
 */
function s053BookingPayload(Agency $agency, Service $service): array
{
    return [
        'customer_name' => 'Client S053',
        'phone' => '+237699053000',
        'whatsapp' => '+237699053000',
        'email' => 'client-s053@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE053AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'Light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-23',
        'preferred_time_slot' => '09h00-10h00',
        'status' => BookingStatus::NewRequest->value,
        'customer_message' => 'Je souhaite confirmer les documents.',
        'public_message' => null,
        'internal_notes' => null,
    ];
}

function s053Booking(Agency $agency, Service $service, string $reference, BookingStatus $status): Booking
{
    return Booking::query()->create([
        ...s053BookingPayload($agency, $service),
        'reference' => $reference,
        'customer_name' => 'Client '.$reference,
        'vehicle_registration' => str($reference)->afterLast('-')->substr(0, 8)->toString(),
        'status' => $status,
    ]);
}

function s053DocumentReadiness(Booking $booking, DocumentReadinessStatus $status): DocumentReadiness
{
    return DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => $status,
    ]);
}
