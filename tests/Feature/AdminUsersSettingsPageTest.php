<?php

use App\Models\Agency;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
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

it('renders the users and settings overview for super admins in English', function () {
    s101UsersSettingsData();
    $superAdmin = s101User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/users-settings?locale=en')
        ->assertOk()
        ->assertSee('Users &amp; Settings', false)
        ->assertSee('Access and system control room')
        ->assertSee('Access workspaces')
        ->assertSee('Role coverage')
        ->assertSee('Latest staff')
        ->assertSee('Audit trail')
        ->assertSee('Agency Staff S101');
});

it('renders the users and settings overview for super admins in French', function () {
    s101UsersSettingsData();
    $superAdmin = s101User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/users-settings?locale=fr')
        ->assertOk()
        ->assertSee('Utilisateurs et réglages')
        ->assertSee('Pilotage accès et paramètres')
        ->assertSee('Espaces d’accès')
        ->assertSee('Couverture des rôles')
        ->assertSee('Derniers utilisateurs')
        ->assertSee('Journal d’audit')
        ->assertSee('Agency Staff S101');
});

it('keeps the users and settings overview restricted to super admins', function (string $role) {
    s101UsersSettingsData();
    $user = s101User($role);

    $this
        ->actingAs($user)
        ->get('/admin/users-settings?locale=en')
        ->assertForbidden();
})->with([
    'agency_admin',
    'content_manager',
]);

/**
 * @return array{agency: Agency, staff: User}
 */
function s101UsersSettingsData(): array
{
    $agency = s101Agency();
    $staff = s101User('agency_admin', $agency, [
        'name' => 'Agency Staff S101',
        'email' => 'agency-staff-s101@example.test',
    ]);
    s101User('content_manager', null, [
        'name' => 'Content Staff S101',
        'email' => 'content-staff-s101@example.test',
        'is_active' => false,
    ]);
    s101User('agency_admin', null, [
        'name' => 'Unassigned Agency S101',
        'email' => 'unassigned-agency-s101@example.test',
    ]);

    Setting::query()->create([
        'key' => 'site_identity_s101',
        'value' => ['name' => 'GS AUTOBILAN'],
    ]);

    Activity::query()->create([
        'log_name' => 'users',
        'description' => 'User updated S101',
        'event' => 'updated',
        'subject_type' => User::class,
        'subject_id' => $staff->id,
        'causer_type' => User::class,
        'causer_id' => $staff->id,
        'properties' => [],
    ]);

    return compact('agency', 'staff');
}

function s101Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 's101-nkolbisson',
        'address_fr' => 'Carrefour Nkolbisson',
        'address_en' => 'Nkolbisson junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678101001'],
        'whatsapp' => '+237678101001',
        'email' => 's101-nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s101User(string $role, ?Agency $agency = null, array $attributes = []): User
{
    $user = User::factory()->create($attributes + [
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
