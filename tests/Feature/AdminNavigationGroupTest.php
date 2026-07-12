<?php

use App\Filament\AdminNavigation;
use App\Filament\Pages\AgenciesServices;
use App\Filament\Pages\Communication;
use App\Filament\Pages\Dashboard;
use App\Filament\Pages\Operations;
use App\Filament\Pages\Tariffs;
use App\Filament\Pages\UsersSettings;
use App\Filament\Pages\WebsiteContent;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationManager;
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

it('registers the S049 admin navigation groups in the documented order', function () {
    $panel = Filament::getPanel('admin');

    expect(collect($panel->getNavigationGroups())->map->getLabel()->all())
        ->toBe(AdminNavigation::labels());

    expect(collect($panel->getNavigationGroups())->map->getIcon()->filter()->all())
        ->toBe([]);
});

it('registers section pages for the admin navigation groups', function () {
    $panel = Filament::getPanel('admin');

    expect($panel->getPages())->toContain(
        Dashboard::class,
        Operations::class,
        WebsiteContent::class,
        AgenciesServices::class,
        Tariffs::class,
        Communication::class,
        UsersSettings::class,
    );
});

it('shows all documented navigation groups to super admins', function () {
    $groups = s049NavigationLabelsFor('super_admin');

    expect($groups)->toBe(AdminNavigation::labels());
});

it('scopes section overview navigation by staff role', function () {
    expect(s049NavigationLabelsFor('agency_admin'))->toBe([
        AdminNavigation::GROUP_DASHBOARD,
        AdminNavigation::GROUP_OPERATIONS,
        AdminNavigation::GROUP_AGENCIES_SERVICES,
        AdminNavigation::GROUP_COMMUNICATION,
    ]);

    expect(s049NavigationLabelsFor('content_manager'))->toBe([
        AdminNavigation::GROUP_DASHBOARD,
        AdminNavigation::GROUP_CONTENT,
        AdminNavigation::GROUP_AGENCIES_SERVICES,
    ]);
});

/**
 * @return list<string>
 */
function s049NavigationLabelsFor(string $role): array
{
    $user = User::factory()->create();
    $user->assignRole($role);

    $panel = Filament::getPanel('admin');
    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    app()->forgetInstance(NavigationManager::class);

    return collect($panel->getNavigation())
        ->map->getLabel()
        ->values()
        ->all();
}
