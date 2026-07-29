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

it('renders the redesigned document readiness desk in English', function () {
    $data = s092DocumentReadinessData();
    $superAdmin = s092User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/document-readiness?locale=en')
        ->assertOk()
        ->assertSee('Document readiness desk')
        ->assertSee('Booking / customer')
        ->assertSee('Booking status')
        ->assertSee('GS-2026-092001')
        ->assertSee('Ready for visit');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/document-readiness/{$data['readiness']->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Booking context')
        ->assertSee('Readiness status')
        ->assertSee('Public next actions');
});

it('renders the redesigned document readiness desk in French', function () {
    $data = s092DocumentReadinessData();
    $agencyAdmin = s092User('agency_admin', $data['agency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/document-readiness?locale=fr')
        ->assertOk()
        ->assertSee('Bureau préparation dossiers')
        ->assertSee('RDV / client')
        ->assertSee('Statut rendez-vous')
        ->assertSee('GS-2026-092001')
        ->assertSee('Prêt pour visite');
});

/**
 * @return array{agency: Agency, service: Service, booking: Booking, readiness: DocumentReadiness}
 */
function s092DocumentReadinessData(): array
{
    $agency = s092Agency();
    $service = s092Service();
    $booking = s092Booking($agency, $service);
    $readiness = DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::ReadyForVisit,
        'next_action_fr' => 'Presentez les originaux.',
        'next_action_en' => 'Bring the originals.',
        'public_message_fr' => 'Votre dossier est pret.',
        'public_message_en' => 'Your file is ready.',
    ]);

    return compact('agency', 'service', 'booking', 'readiness');
}

function s092User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s092Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 's092-nkolbisson',
        'address_fr' => 'Carrefour Nkolbisson',
        'address_en' => 'Nkolbisson junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678092001'],
        'whatsapp' => '+237678092001',
        'email' => 's092-nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s092Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Controle documentaire S092',
        'title_en' => 'S092 document inspection',
        'slug_fr' => 'controle-documentaire-s092',
        'slug_en' => 's092-document-inspection',
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s092Booking(Agency $agency, Service $service): Booking
{
    return Booking::query()->create([
        'reference' => 'GS-2026-092001',
        'customer_name' => 'Client S092',
        'phone' => '+237699092001',
        'whatsapp' => '+237699092001',
        'email' => 'client-s092@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE092AB',
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
