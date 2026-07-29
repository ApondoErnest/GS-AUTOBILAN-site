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

it('renders the redesigned tariffs resource in English', function () {
    $tariff = s098Tariff();
    $superAdmin = s098User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/tariffs?locale=en')
        ->assertOk()
        ->assertSee('Tariff catalogue')
        ->assertSee('Vehicle / category')
        ->assertSee('Pricing state')
        ->assertSee('Pending official tariff')
        ->assertSee('Light vehicles');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/tariffs/{$tariff->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Vehicle and category')
        ->assertSee('Price and publication')
        ->assertSee('Public notes');
});

it('renders the redesigned tariffs resource in French', function () {
    s098Tariff();
    $superAdmin = s098User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/tariffs?locale=fr')
        ->assertOk()
        ->assertSee('Catalogue tarifs')
        ->assertSee('Véhicule / catégorie')
        ->assertSee('État tarifaire')
        ->assertSee('Tarif officiel en attente')
        ->assertSee('Véhicules légers')
        ->assertSee('Provisoire');
});

function s098Tariff(): Tariff
{
    return Tariff::query()->create([
        'category' => 'light',
        'vehicle_type_fr' => 'Véhicules légers',
        'vehicle_type_en' => 'Light vehicles',
        'price' => null,
        'currency' => 'XAF',
        'validity' => 'Annual',
        'notes_fr' => 'Tarif officiel en attente de confirmation.',
        'notes_en' => 'Official tariff pending confirmation.',
        'sort_order' => 1,
        'is_active' => true,
        'is_placeholder' => true,
        'last_updated_at' => null,
    ]);
}

function s098User(string $role): User
{
    $user = User::factory()->create();

    $user->assignRole($role);

    return $user->fresh();
}
