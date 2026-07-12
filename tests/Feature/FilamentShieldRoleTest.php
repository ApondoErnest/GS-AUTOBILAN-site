<?php

use App\Models\User;
use BezhanSalleh\FilamentShield\Resources\Roles\RoleResource;
use Database\Seeders\DatabaseSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();
});

it('registers Shield on the admin panel with the GS role configuration', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->hasPlugin('filament-shield'))->toBeTrue();
    expect($panel->getResources())->toContain(RoleResource::class);

    expect(config('filament-shield.auth_provider_model'))->toBe(User::class);
    expect(config('filament-shield.super_admin.name'))->toBe('super_admin');
    expect(config('filament-shield.panel_user.enabled'))->toBeFalse();
    expect(config('filament-shield.policies.generate'))->toBeFalse();
});

it('seeds the three staff roles and allows assigning them to users', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Role::query()->orderBy('name')->pluck('name')->all())->toBe([
        'agency_admin',
        'content_manager',
        'super_admin',
    ]);

    $user = User::factory()->create();
    $user->assignRole(['super_admin', 'agency_admin', 'content_manager']);

    expect($user->fresh()->hasAllRoles([
        'super_admin',
        'agency_admin',
        'content_manager',
    ]))->toBeTrue();
});

it('limits admin panel access to active users with a staff role', function () {
    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }

    $panel = Filament::getPanel('admin');
    $unassigned = User::factory()->create();
    $inactiveSuperAdmin = User::factory()->create(['is_active' => false]);
    $inactiveSuperAdmin->assignRole('super_admin');

    expect($unassigned->canAccessPanel($panel))->toBeFalse();
    expect($inactiveSuperAdmin->fresh()->canAccessPanel($panel))->toBeFalse();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        $user = User::factory()->create();
        $user->assignRole($role);

        expect($user->fresh()->canAccessPanel($panel))->toBeTrue();
    }
});

it('allows only super admins to manage Shield roles', function () {
    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }

    $role = Role::findByName('agency_admin', 'web');
    $superAdmin = s048UserWithRole('super_admin');
    $agencyAdmin = s048UserWithRole('agency_admin');
    $contentManager = s048UserWithRole('content_manager');

    expect($superAdmin->can('viewAny', Role::class))->toBeTrue();
    expect($superAdmin->can('create', Role::class))->toBeTrue();
    expect($superAdmin->can('update', $role))->toBeTrue();
    expect($superAdmin->can('delete', $role))->toBeTrue();

    foreach ([$agencyAdmin, $contentManager] as $user) {
        expect($user->can('viewAny', Role::class))->toBeFalse();
        expect($user->can('create', Role::class))->toBeFalse();
        expect($user->can('update', $role))->toBeFalse();
        expect($user->can('delete', $role))->toBeFalse();
    }
});

function s048UserWithRole(string $role): User
{
    $user = User::factory()->create();
    $user->assignRole($role);

    return $user->fresh();
}
