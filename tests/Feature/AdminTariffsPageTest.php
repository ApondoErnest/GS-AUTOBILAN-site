<?php

use App\Models\Tariff;
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

it('renders the tariffs overview for super admins in English', function () {
    s097TariffsData();
    $superAdmin = s097User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/tariffs-overview?locale=en')
        ->assertOk()
        ->assertSee('Public tariff control')
        ->assertSee('Tariff workspace')
        ->assertSee('Publication readiness')
        ->assertSee('Latest tariff rows')
        ->assertSee('Attention queue')
        ->assertSee('Light vehicles')
        ->assertSee('Pending official tariff');
});

it('renders the tariffs overview for super admins in French', function () {
    s097TariffsData();
    $superAdmin = s097User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/tariffs-overview?locale=fr')
        ->assertOk()
        ->assertSee('Tarifs')
        ->assertSee('Pilotage des tarifs publics')
        ->assertSee('Espace tarifs')
        ->assertSee('Préparation publication')
        ->assertSee('Dernières lignes tarifaires')
        ->assertSee('Véhicules légers')
        ->assertSee('Tarif officiel en attente');
});

it('keeps the tariffs overview restricted to super admins', function (string $role) {
    s097TariffsData();
    $user = s097User($role);

    $this
        ->actingAs($user)
        ->get('/admin/tariffs-overview?locale=en')
        ->assertForbidden();
})->with([
    'agency_admin',
    'content_manager',
]);

function s097TariffsData(): void
{
    s097Tariff('light', 'Véhicules légers', 'Light vehicles', null, true, true, 1);
    s097Tariff('utility', 'Véhicules utilitaires', 'Utility vehicles', 35000, false, true, 2);
    s097Tariff('heavy_goods', 'Poids lourds', 'Heavy goods vehicles', 70000, false, false, 3, null);
}

function s097Tariff(
    string $category,
    string $vehicleTypeFr,
    string $vehicleTypeEn,
    ?int $price,
    bool $isPlaceholder,
    bool $isActive,
    int $sortOrder,
    ?string $lastUpdatedAt = '2026-07-29 09:00:00',
): Tariff {
    return Tariff::query()->create([
        'category' => $category,
        'vehicle_type_fr' => $vehicleTypeFr,
        'vehicle_type_en' => $vehicleTypeEn,
        'price' => $price,
        'currency' => 'XAF',
        'validity' => 'Annual',
        'notes_fr' => 'Tarif officiel en attente de confirmation.',
        'notes_en' => 'Official tariff pending confirmation.',
        'sort_order' => $sortOrder,
        'is_active' => $isActive,
        'is_placeholder' => $isPlaceholder,
        'last_updated_at' => $lastUpdatedAt,
    ]);
}

function s097User(string $role): User
{
    $user = User::factory()->create();

    $user->assignRole($role);

    return $user->fresh();
}
