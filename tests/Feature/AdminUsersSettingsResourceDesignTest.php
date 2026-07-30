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

it('renders the redesigned users resource in English', function () {
    $data = s102UsersSettingsData();
    $superAdmin = s102User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/users?locale=en')
        ->assertOk()
        ->assertSee('Staff directory')
        ->assertSee('Staff / identity')
        ->assertSee('Roles')
        ->assertSee('Access status')
        ->assertSee('Agency Staff S102')
        ->assertSee('Agency Admin');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/users/{$data['staff']->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('User identity')
        ->assertSee('Access and agency')
        ->assertSee('Staff roles');
});

it('renders the redesigned users resource in French', function () {
    s102UsersSettingsData();
    $superAdmin = s102User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/users?locale=fr')
        ->assertOk()
        ->assertSee('Répertoire staff')
        ->assertSee('Staff / identité')
        ->assertSee('Rôles')
        ->assertSee('État d’accès')
        ->assertSee('Agency Staff S102')
        ->assertSee('Admin agence');
});

it('renders the redesigned settings resource in both languages', function () {
    $data = s102UsersSettingsData();
    $superAdmin = s102User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/settings?locale=en')
        ->assertOk()
        ->assertSee('System settings')
        ->assertSee('Key / area')
        ->assertSee('JSON value')
        ->assertSee('site_identity_s102');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/settings/{$data['setting']->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Configuration key')
        ->assertSee('Structured value');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/settings?locale=fr')
        ->assertOk()
        ->assertSee('Réglages système')
        ->assertSee('Clé / zone')
        ->assertSee('Valeur JSON');
});

it('renders the redesigned audit resource in both languages', function () {
    s102UsersSettingsData();
    $superAdmin = s102User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/audit?locale=en')
        ->assertOk()
        ->assertSee('Audit trail')
        ->assertSee('Activity')
        ->assertSee('Log')
        ->assertSee('Event')
        ->assertSee('User updated S102');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/audit?locale=fr')
        ->assertOk()
        ->assertSee('Journal d’audit')
        ->assertSee('Activité')
        ->assertSee('Journal')
        ->assertSee('Événement');
});

/**
 * @return array{agency: Agency, staff: User, setting: Setting}
 */
function s102UsersSettingsData(): array
{
    $agency = s102Agency();
    $staff = s102User('agency_admin', $agency, [
        'name' => 'Agency Staff S102',
        'email' => 'agency-staff-s102@example.test',
        'last_login_at' => '2026-07-30 08:00:00',
    ]);
    $setting = Setting::query()->create([
        'key' => 'site_identity_s102',
        'value' => [
            'name' => 'GS AUTOBILAN',
            'default_locale' => 'fr',
        ],
    ]);

    Activity::query()->create([
        'log_name' => 'users',
        'description' => 'User updated S102',
        'event' => 'updated',
        'subject_type' => User::class,
        'subject_id' => $staff->id,
        'causer_type' => User::class,
        'causer_id' => $staff->id,
        'properties' => [],
    ]);

    return compact('agency', 'staff', 'setting');
}

function s102Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 's102-nkolbisson',
        'address_fr' => 'Carrefour Nkolbisson',
        'address_en' => 'Nkolbisson junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678102001'],
        'whatsapp' => '+237678102001',
        'email' => 's102-nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s102User(string $role, ?Agency $agency = null, array $attributes = []): User
{
    $user = User::factory()->create($attributes + [
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
