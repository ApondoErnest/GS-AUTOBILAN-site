<?php

use App\Models\Agency;
use App\Models\Service;
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

it('renders the redesigned agencies resource in English', function () {
    $agency = s094Agency();
    $superAdmin = s094User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/agencies?locale=en')
        ->assertOk()
        ->assertSee('Agency directory')
        ->assertSee('Agency / location')
        ->assertSee('Public visibility')
        ->assertSee('GS AUTOBILAN Nkolbisson')
        ->assertSee('Operational');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/agencies/{$agency->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Agency identity')
        ->assertSee('Public contact')
        ->assertSee('Opening hours');
});

it('renders the redesigned agencies resource in French for agency admins', function () {
    $agency = s094Agency();
    $agencyAdmin = s094User('agency_admin', $agency);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/agencies?locale=fr')
        ->assertOk()
        ->assertSee('Répertoire agences')
        ->assertSee('Agence / localisation')
        ->assertSee('Visibilité publique')
        ->assertSee('GS AUTOBILAN Nkolbisson')
        ->assertSee('Opérationnelle');
});

it('renders the redesigned services resource in English', function () {
    $service = s094Service();
    $contentManager = s094User('content_manager');

    $this
        ->actingAs($contentManager)
        ->get('/admin/services?locale=en')
        ->assertOk()
        ->assertSee('Service catalogue')
        ->assertSee('Service / summary')
        ->assertSee('Missing image')
        ->assertSee('Technical inspection')
        ->assertSee('Active');

    $this
        ->actingAs($contentManager)
        ->get("/admin/services/{$service->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Bilingual service content')
        ->assertSee('Media and visibility')
        ->assertSee('Detailed descriptions');
});

it('renders the redesigned services resource in French', function () {
    s094Service();
    $contentManager = s094User('content_manager');

    $this
        ->actingAs($contentManager)
        ->get('/admin/services?locale=fr')
        ->assertOk()
        ->assertSee('Catalogue services')
        ->assertSee('Service / résumé')
        ->assertSee('Image manquante')
        ->assertSee('Contrôle technique')
        ->assertSee('Actif');
});

function s094Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 's094-nkolbisson',
        'address_fr' => 'Carrefour Nkolbisson',
        'address_en' => 'Nkolbisson junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678094001'],
        'whatsapp' => '+237678094001',
        'email' => 's094-nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'map_link' => 'https://maps.example.test/nkolbisson',
        'status' => 'operational',
        'sort_order' => 1,
        'description_fr' => 'Agence de contrôle technique.',
        'description_en' => 'Technical inspection agency.',
        'is_active' => true,
    ]);
}

function s094Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Contrôle technique',
        'title_en' => 'Technical inspection',
        'slug_fr' => 'controle-technique-s094',
        'slug_en' => 'technical-inspection-s094',
        'short_description_fr' => 'Service public bilingue.',
        'short_description_en' => 'Bilingual public service.',
        'full_description_fr' => 'Description longue du service.',
        'full_description_en' => 'Long service description.',
        'icon' => 'wrench',
        'image' => 'services/technical-inspection-s094.jpg',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s094User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
