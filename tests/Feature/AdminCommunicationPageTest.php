<?php

use App\Enums\ContactStatus;
use App\Models\Agency;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app()->setLocale('en');
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

afterEach(function () {
    app()->setLocale('en');
});

it('renders the communication overview for super admins in English', function () {
    s099CommunicationData();
    $superAdmin = s099User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/communication?locale=en')
        ->assertOk()
        ->assertSee('Communication')
        ->assertSee('Customer communication desk')
        ->assertSee('Message inbox')
        ->assertSee('Response workload')
        ->assertSee('Latest messages')
        ->assertSee('Attention queue')
        ->assertSee('Demande S099 Nkolbisson')
        ->assertSee('New');
});

it('renders the communication overview for agency admins in French with agency scope', function () {
    $data = s099CommunicationData();
    $agencyAdmin = s099User('agency_admin', $data['agency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/communication?locale=fr')
        ->assertOk()
        ->assertSee('Pilotage des messages clients')
        ->assertSee('Boîte de réception')
        ->assertSee('Charge de traitement')
        ->assertSee('Derniers messages')
        ->assertSee('Demande S099 Nkolbisson')
        ->assertSee('Nouveau')
        ->assertDontSee('Demande S099 Obili');
});

it('keeps the communication overview unavailable to content managers', function () {
    s099CommunicationData();
    $contentManager = s099User('content_manager');

    $this
        ->actingAs($contentManager)
        ->get('/admin/communication?locale=en')
        ->assertForbidden();
});

/**
 * @return array{agency: Agency, otherAgency: Agency}
 */
function s099CommunicationData(): array
{
    $agency = s099Agency('nkolbisson', 1);
    $otherAgency = s099Agency('obili', 2);

    s099ContactMessage($agency, 'Demande S099 Nkolbisson', ContactStatus::New);
    s099ContactMessage($agency, 'Suivi S099 Nkolbisson', ContactStatus::InReview);
    s099ContactMessage($otherAgency, 'Demande S099 Obili', ContactStatus::Responded);

    return compact('agency', 'otherAgency');
}

function s099Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => 's099-'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678099001'],
        'whatsapp' => '+237678099001',
        'email' => 's099-'.$slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s099ContactMessage(Agency $agency, string $subject, ContactStatus $status): ContactMessage
{
    return ContactMessage::query()->create([
        'name' => 'Client S099',
        'phone' => '+237677099001',
        'email' => 'client-s099@example.test',
        'agency_id' => $agency->id,
        'subject' => $subject,
        'message' => 'Je voudrais des informations sur ma visite technique.',
        'status' => $status,
        'assigned_user_id' => null,
        'internal_notes' => null,
    ]);
}

function s099User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
