<?php

use App\Filament\Resources\TariffResource;
use App\Filament\Resources\TariffResource\Pages\CreateTariff;
use App\Filament\Resources\TariffResource\Pages\EditTariff;
use App\Filament\Resources\TariffResource\Pages\ListTariffs;
use App\Models\Tariff;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

it('registers the S052 tariff resource on the admin panel', function () {
    expect(Filament::getPanel('admin')->getResources())
        ->toContain(TariffResource::class);
});

it('allows super admins to manage tariffs and see placeholder status', function () {
    s052ActingAs(s052User('super_admin'));

    Livewire::test(CreateTariff::class)
        ->fillForm(s052TariffPayload('light'))
        ->call('create')
        ->assertHasNoFormErrors();

    $tariff = Tariff::query()->where('category', 'light')->firstOrFail();

    expect($tariff)
        ->vehicle_type_fr->toBe('Vehicules legers')
        ->is_placeholder->toBeTrue();

    $this->get('/admin/tariffs')->assertOk();

    Livewire::test(ListTariffs::class)
        ->assertCanSeeTableRecords([$tariff])
        ->assertTableColumnFormattedStateSet('is_placeholder', 'Placeholder', $tariff)
        ->assertTableColumnFormattedStateSet('price', 'Pending official tariff', $tariff);

    Livewire::test(EditTariff::class, ['record' => $tariff->id])
        ->fillForm([
            'price' => 25000,
            'is_placeholder' => false,
            'last_updated_at' => now()->format('Y-m-d H:i:s'),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $tariff = $tariff->fresh();

    expect($tariff)
        ->price->toBe('25000.00')
        ->is_placeholder->toBeFalse();

    expect(Activity::query()
        ->where('log_name', 'tariffs')
        ->where('event', 'updated')
        ->where('subject_type', Tariff::class)
        ->where('subject_id', $tariff->id)
        ->exists())->toBeTrue();

    Livewire::test(EditTariff::class, ['record' => $tariff->id])
        ->callAction(DeleteAction::class);

    expect(Tariff::query()->whereKey($tariff->id)->exists())->toBeFalse();
});

it('keeps tariff resources unavailable to non super admin staff', function (string $role) {
    s052ActingAs(s052User($role));

    expect(TariffResource::canAccess())->toBeFalse();

    $this->get('/admin/tariffs')->assertForbidden();
    $this->get('/admin/tariffs/create')->assertForbidden();
})->with([
    'agency_admin',
    'content_manager',
]);

function s052ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s052User(string $role): User
{
    $user = User::factory()->create();

    $user->assignRole($role);

    return $user->fresh();
}

/**
 * @return array<string, mixed>
 */
function s052TariffPayload(string $category): array
{
    return [
        'category' => $category,
        'vehicle_type_fr' => 'Vehicules legers',
        'vehicle_type_en' => 'Light vehicles',
        'price' => null,
        'currency' => 'XAF',
        'validity' => 'Annual',
        'notes_fr' => 'Tarif en attente de confirmation officielle.',
        'notes_en' => 'Tariff pending official confirmation.',
        'sort_order' => 1,
        'is_active' => true,
        'is_placeholder' => true,
        'last_updated_at' => null,
    ];
}
