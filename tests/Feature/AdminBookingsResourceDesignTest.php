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

it('renders the redesigned bookings desk in English', function () {
    $data = s091BookingsData();
    $superAdmin = s091User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/bookings?locale=en')
        ->assertOk()
        ->assertSee('Booking desk')
        ->assertSee('Agency / service')
        ->assertSee('Document status')
        ->assertSee('GS-2026-091001')
        ->assertSee('Ready for visit');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/bookings/{$data['booking']->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Schedule and status')
        ->assertSee('Messages and notes');
});

it('renders the redesigned bookings desk in French', function () {
    $data = s091BookingsData();
    $agencyAdmin = s091User('agency_admin', $data['agency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/bookings?locale=fr')
        ->assertOk()
        ->assertSee('Bureau rendez-vous')
        ->assertSee('Agence / service')
        ->assertSee('Statut dossier')
        ->assertSee('GS-2026-091001')
        ->assertSee('Prêt pour visite');
});

/**
 * @return array{agency: Agency, service: Service, booking: Booking}
 */
function s091BookingsData(): array
{
    $agency = s091Agency();
    $service = s091Service();
    $booking = s091Booking($agency, $service);

    DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::ReadyForVisit,
    ]);

    return compact('agency', 'service', 'booking');
}

function s091User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s091Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 's091-nkolbisson',
        'address_fr' => 'Carrefour Nkolbisson',
        'address_en' => 'Nkolbisson junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678091001'],
        'whatsapp' => '+237678091001',
        'email' => 's091-nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s091Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Controle premium S091',
        'title_en' => 'S091 premium inspection',
        'slug_fr' => 'controle-premium-s091',
        'slug_en' => 's091-premium-inspection',
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s091Booking(Agency $agency, Service $service): Booking
{
    return Booking::query()->create([
        'reference' => 'GS-2026-091001',
        'customer_name' => 'Client S091',
        'phone' => '+237699091001',
        'whatsapp' => '+237699091001',
        'email' => 'client-s091@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE091AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'Light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => today(),
        'preferred_time_slot' => '09h00-10h00',
        'confirmed_date' => today(),
        'confirmed_time_slot' => '10h00-11h00',
        'status' => BookingStatus::Confirmed,
    ]);
}
