<?php

use App\Enums\BookingStatus;
use App\Enums\ContactStatus;
use App\Enums\DocumentReadinessStatus;
use App\Filament\Resources\AgencyResource;
use App\Filament\Resources\AgencyResource\Pages\ListAgencies;
use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Filament\Resources\DocumentReadinessResource;
use App\Filament\Resources\DocumentReadinessResource\Pages\ListDocumentReadiness;
use App\Filament\Support\DashboardMetrics;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\ContactMessage;
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

it('keeps S082 agency admin Filament records inside the assigned agency', function () {
    $data = s082IsolationData();
    $agencyAdmin = s082User('agency_admin', $data['agency']);

    s082ActingAs($agencyAdmin);

    $this->get('/admin/agencies')->assertOk();
    $this->get('/admin/bookings')->assertOk();
    $this->get('/admin/document-readiness')->assertOk();
    $this->get('/admin/contact-messages')->assertOk();

    $this->get("/admin/bookings/{$data['otherBooking']->id}/edit")->assertNotFound();
    $this->get("/admin/bookings/{$data['otherUnreviewedBooking']->id}/edit")->assertNotFound();
    $this->get("/admin/document-readiness/{$data['otherReadiness']->id}/edit")->assertNotFound();
    $this->get("/admin/contact-messages/{$data['otherContactMessage']->id}/edit")->assertNotFound();
    $this->get("/admin/contact-messages/{$data['unassignedContactMessage']->id}/edit")->assertNotFound();

    expect(s082ResourceIds(AgencyResource::getEloquentQuery()))
        ->toBe([$data['agency']->id])
        ->not->toContain($data['otherAgency']->id);

    expect(s082ResourceIds(BookingResource::getEloquentQuery()))
        ->toBe([
            $data['booking']->id,
            $data['unreviewedBooking']->id,
        ])
        ->not->toContain($data['otherBooking']->id, $data['otherUnreviewedBooking']->id);

    expect(s082ResourceIds(DocumentReadinessResource::getEloquentQuery()))
        ->toBe([$data['readiness']->id])
        ->not->toContain($data['otherReadiness']->id);

    expect(s082ResourceIds(ContactMessageResource::getEloquentQuery()))
        ->toBe([$data['contactMessage']->id])
        ->not->toContain($data['otherContactMessage']->id, $data['unassignedContactMessage']->id);

    Livewire::test(ListAgencies::class)
        ->assertCanSeeTableRecords([$data['agency']])
        ->assertCanNotSeeTableRecords([$data['otherAgency']]);

    Livewire::test(ListBookings::class)
        ->assertCanSeeTableRecords([$data['booking'], $data['unreviewedBooking']])
        ->assertCanNotSeeTableRecords([$data['otherBooking'], $data['otherUnreviewedBooking']]);

    Livewire::test(ListDocumentReadiness::class)
        ->assertCanSeeTableRecords([$data['readiness']])
        ->assertCanNotSeeTableRecords([$data['otherReadiness']]);

    Livewire::test(ListContactMessages::class)
        ->assertCanSeeTableRecords([$data['contactMessage']])
        ->assertCanNotSeeTableRecords([$data['otherContactMessage'], $data['unassignedContactMessage']]);

    expect(BookingResource::agencyOptions())->toBe([
        $data['agency']->id => $data['agency']->name_fr,
    ]);
    expect(ContactMessageResource::agencyOptions())->toBe([
        $data['agency']->id => $data['agency']->name_fr,
    ]);

    $bookingOptions = DocumentReadinessResource::bookingOptions();

    expect($bookingOptions)
        ->toHaveKey($data['unreviewedBooking']->id)
        ->not->toHaveKey($data['otherUnreviewedBooking']->id);

    expect(DashboardMetrics::bookingCounts($agencyAdmin))
        ->toMatchArray([
            'total' => 2,
            'new' => 1,
            'pending' => 0,
            'confirmed' => 1,
        ]);
    expect(DashboardMetrics::agencyBookingBreakdown($agencyAdmin)->all())->toBe([
        ['label' => $data['agency']->name_fr, 'count' => 2],
    ]);
});

it('keeps S082 unassigned agency admins out of scoped admin resources', function () {
    s082IsolationData();

    s082ActingAs(s082User('agency_admin'));

    expect(AgencyResource::canAccess())->toBeFalse();
    expect(BookingResource::canAccess())->toBeFalse();
    expect(DocumentReadinessResource::canAccess())->toBeFalse();
    expect(ContactMessageResource::canAccess())->toBeFalse();

    $this->get('/admin/agencies')->assertForbidden();
    $this->get('/admin/bookings')->assertForbidden();
    $this->get('/admin/document-readiness')->assertForbidden();
    $this->get('/admin/contact-messages')->assertForbidden();
});

function s082ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s082User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

/**
 * @return array<string, mixed>
 */
function s082IsolationData(): array
{
    $agency = s082Agency('nkolbisson', 1);
    $otherAgency = s082Agency('obili-scalom', 2);
    $service = s082Service();

    $booking = s082Booking($agency, $service, 'GS-2026-082001', BookingStatus::Confirmed);
    $otherBooking = s082Booking($otherAgency, $service, 'GS-2026-082002', BookingStatus::Confirmed);
    $unreviewedBooking = s082Booking($agency, $service, 'GS-2026-082003', BookingStatus::NewRequest);
    $otherUnreviewedBooking = s082Booking($otherAgency, $service, 'GS-2026-082004', BookingStatus::NewRequest);

    $readiness = s082DocumentReadiness($booking, DocumentReadinessStatus::ReadyForVisit);
    $otherReadiness = s082DocumentReadiness($otherBooking, DocumentReadinessStatus::MissingInfo);

    $contactMessage = s082ContactMessage($agency, 'Demande S082 Nkolbisson');
    $otherContactMessage = s082ContactMessage($otherAgency, 'Demande S082 Obili');
    $unassignedContactMessage = ContactMessage::query()->create([
        'name' => 'Client S082 Non Assigne',
        'phone' => '+237677082999',
        'email' => 's082-unassigned@example.test',
        'agency_id' => null,
        'subject' => 'Demande S082 non assignee',
        'message' => 'Message hors agence.',
        'status' => ContactStatus::New,
    ]);

    return compact(
        'agency',
        'otherAgency',
        'booking',
        'otherBooking',
        'unreviewedBooking',
        'otherUnreviewedBooking',
        'readiness',
        'otherReadiness',
        'contactMessage',
        'otherContactMessage',
        'unassignedContactMessage',
    );
}

function s082Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => 's082-'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678082001'],
        'whatsapp' => '+237678082001',
        'email' => 's082-'.$slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s082Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Controle S082',
        'title_en' => 'S082 inspection',
        'slug_fr' => 'controle-s082',
        'slug_en' => 's082-inspection',
        'short_description_fr' => 'Controle technique S082.',
        'short_description_en' => 'S082 technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s082Booking(Agency $agency, Service $service, string $reference, BookingStatus $status): Booking
{
    return Booking::query()->create([
        'reference' => $reference,
        'customer_name' => 'Client '.$reference,
        'phone' => '+237699'.substr($reference, -6),
        'whatsapp' => '+237699'.substr($reference, -6),
        'email' => strtolower($reference).'@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE'.substr($reference, -3).'AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-08-05',
        'preferred_time_slot' => 'Matin - 07h00-11h00',
        'confirmed_date' => $status === BookingStatus::Confirmed ? '2026-08-06' : null,
        'confirmed_time_slot' => $status === BookingStatus::Confirmed ? '08h00-09h00' : null,
        'status' => $status,
    ]);
}

function s082DocumentReadiness(Booking $booking, DocumentReadinessStatus $status): DocumentReadiness
{
    return DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => $status,
        'missing_information_note' => $status === DocumentReadinessStatus::MissingInfo ? 'Note agence externe.' : null,
    ]);
}

function s082ContactMessage(Agency $agency, string $subject): ContactMessage
{
    return ContactMessage::query()->create([
        'name' => 'Client '.$subject,
        'phone' => '+237677082000',
        'email' => str($subject)->slug().'-s082@example.test',
        'agency_id' => $agency->id,
        'subject' => $subject,
        'message' => 'Message public S082.',
        'status' => ContactStatus::New,
    ]);
}

/**
 * @return array<int, int>
 */
function s082ResourceIds($query): array
{
    return $query
        ->pluck('id')
        ->sort()
        ->values()
        ->all();
}
