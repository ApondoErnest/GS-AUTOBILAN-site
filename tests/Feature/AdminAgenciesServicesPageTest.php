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

it('renders the agencies and services overview for super admins in English', function () {
    s093AgenciesServicesData();
    $superAdmin = s093User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/agencies-services?locale=en')
        ->assertOk()
        ->assertSee('Agencies &amp; Services', false)
        ->assertSee('Agency network and service catalogue')
        ->assertSee('Management workspaces')
        ->assertSee('Public readiness')
        ->assertSee('Latest agencies')
        ->assertSee('Latest services')
        ->assertSee('GS AUTOBILAN Nkolbisson')
        ->assertSee('Technical inspection');
});

it('renders the agencies and services overview for content managers in French', function () {
    s093AgenciesServicesData();
    $contentManager = s093User('content_manager');

    $this
        ->actingAs($contentManager)
        ->get('/admin/agencies-services?locale=fr')
        ->assertOk()
        ->assertSee('Agences et services')
        ->assertSee('Réseau d’agences et catalogue services')
        ->assertSee('Espaces de gestion')
        ->assertSee('Préparation publique')
        ->assertSee('Derniers services')
        ->assertSee('Contrôle technique')
        ->assertDontSee('GS AUTOBILAN Nkolbisson');
});

it('scopes agency admins to their assigned agency on the overview', function () {
    $data = s093AgenciesServicesData();
    $agencyAdmin = s093User('agency_admin', $data['assignedAgency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/agencies-services?locale=en')
        ->assertOk()
        ->assertSee('Latest agencies')
        ->assertSee('GS AUTOBILAN Nkolbisson')
        ->assertDontSee('GS AUTOBILAN Obili')
        ->assertDontSee('Latest services');
});

/**
 * @return array{assignedAgency: Agency, otherAgency: Agency, inactiveAgency: Agency, activeService: Service, inactiveService: Service}
 */
function s093AgenciesServicesData(): array
{
    $assignedAgency = s093Agency('nkolbisson', 1, 'operational', true);
    $otherAgency = s093Agency('obili', 2, 'temporarily_closed', true);
    $inactiveAgency = s093Agency('mvog-ada', 3, 'operational', false);
    $activeService = s093Service('technical-inspection', 1, true);
    $inactiveService = s093Service('fleet-support', 2, false);

    return compact('assignedAgency', 'otherAgency', 'inactiveAgency', 'activeService', 'inactiveService');
}

function s093Agency(string $slug, int $sortOrder, string $status, bool $isActive): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => 's093-'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678093001'],
        'whatsapp' => '+237678093001',
        'email' => 's093-'.$slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'map_link' => 'https://maps.example.test/'.$slug,
        'status' => $status,
        'sort_order' => $sortOrder,
        'description_fr' => 'Agence de contrôle technique.',
        'description_en' => 'Technical inspection agency.',
        'is_active' => $isActive,
    ]);
}

function s093Service(string $slug, int $sortOrder, bool $isActive): Service
{
    return Service::query()->create([
        'title_fr' => $slug === 'technical-inspection' ? 'Contrôle technique' : 'Support flottes',
        'title_en' => $slug === 'technical-inspection' ? 'Technical inspection' : 'Fleet support',
        'slug_fr' => 's093-'.$slug.'-fr',
        'slug_en' => 's093-'.$slug.'-en',
        'short_description_fr' => 'Service public bilingue.',
        'short_description_en' => 'Bilingual public service.',
        'full_description_fr' => 'Description longue du service.',
        'full_description_en' => 'Long service description.',
        'icon' => 'wrench',
        'image' => $isActive ? 'services/'.$slug.'.jpg' : null,
        'sort_order' => $sortOrder,
        'is_active' => $isActive,
    ]);
}

function s093User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
