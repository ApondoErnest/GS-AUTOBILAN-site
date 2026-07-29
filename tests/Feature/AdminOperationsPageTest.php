<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

it('renders the operations section with compact operational data in English', function () {
    s090OperationsData();
    $superAdmin = s090User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/operations?locale=en')
        ->assertOk()
        ->assertSee('Operations')
        ->assertSee('Today&#039;s operational pulse', false)
        ->assertSee('Priority actions')
        ->assertSee('Latest bookings')
        ->assertSee('Document readiness')
        ->assertSee('GS-2026-090001');
});

it('renders the operations section in French', function () {
    $data = s090OperationsData();
    $agencyAdmin = s090User('agency_admin', $data['agency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/operations?locale=fr')
        ->assertOk()
        ->assertSee('Opérations')
        ->assertSee('Pouls opérationnel du jour')
        ->assertSee('Actions prioritaires')
        ->assertSee('Derniers rendez-vous')
        ->assertSee('Préparation dossiers');
});

it('handles agency admins without an assigned operation scope', function () {
    s090OperationsData();
    $agencyAdmin = s090User('agency_admin');

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/operations?locale=en')
        ->assertOk()
        ->assertSee('No operational shortcuts are available')
        ->assertSee('No bookings are visible yet.')
        ->assertSee('No document readiness records are visible yet.');
});

/**
 * @return array{agency: Agency, otherAgency: Agency, service: Service}
 */
function s090OperationsData(): array
{
    $agency = s090Agency('nkolbisson', 1);
    $otherAgency = s090Agency('obili-scalom', 2);
    $service = s090Service();

    $booking = s090Booking($agency, $service, 'GS-2026-090001', BookingStatus::NewRequest);
    $confirmedBooking = s090Booking($agency, $service, 'GS-2026-090002', BookingStatus::Confirmed);
    $otherBooking = s090Booking($otherAgency, $service, 'GS-2026-090003', BookingStatus::PendingConfirmation);

    s090DocumentReadiness($booking, DocumentReadinessStatus::MissingInfo);
    s090DocumentReadiness($confirmedBooking, DocumentReadinessStatus::ReadyForVisit);
    s090DocumentReadiness($otherBooking, DocumentReadinessStatus::ContactAgency);

    return compact('agency', 'otherAgency', 'service');
}

function s090User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s090Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => 's090-'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678090001'],
        'whatsapp' => '+237678090001',
        'email' => 's090-'.$slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s090Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Controle S090',
        'title_en' => 'S090 inspection',
        'slug_fr' => 'controle-s090',
        'slug_en' => 's090-inspection',
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s090Booking(Agency $agency, Service $service, string $reference, BookingStatus $status): Booking
{
    return Booking::query()->create([
        'reference' => $reference,
        'customer_name' => 'Client S090',
        'phone' => '+237699090001',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE090AB',
        'vehicle_type' => 'Car',
        'preferred_date' => today(),
        'preferred_time_slot' => '09h00-10h00',
        'status' => $status,
    ]);
}

function s090DocumentReadiness(Booking $booking, DocumentReadinessStatus $status): DocumentReadiness
{
    return DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => $status,
    ]);
}
