<?php

use App\Filament\Resources\AgencyResource;
use App\Filament\Resources\AgencyResource\Pages\CreateAgency;
use App\Filament\Resources\AgencyResource\Pages\EditAgency;
use App\Filament\Resources\AgencyResource\Pages\ListAgencies;
use App\Filament\Resources\ServiceResource;
use App\Filament\Resources\ServiceResource\Pages\CreateService;
use App\Filament\Resources\ServiceResource\Pages\EditService;
use App\Models\Agency;
use App\Models\Service;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

it('registers the S051 agency and service resources on the admin panel', function () {
    $resources = Filament::getPanel('admin')->getResources();

    expect($resources)->toContain(
        AgencyResource::class,
        ServiceResource::class,
    );
});

it('allows super admins to create and edit agencies from Filament', function () {
    s051ActingAs(s051User('super_admin'));

    Livewire::test(CreateAgency::class)
        ->fillForm(s051AgencyPayload('mvog-ada'))
        ->call('create')
        ->assertHasNoFormErrors();

    $agency = Agency::query()->where('slug', 'mvog-ada')->firstOrFail();

    expect($agency->phones)->toBe(['+237678000001', '+237678000002'])
        ->and($agency->opening_hours_fr)->toBe(['monday_saturday' => '07h00-18h00']);

    Livewire::test(EditAgency::class, ['record' => $agency->id])
        ->fillForm([
            'name_fr' => 'GS AUTOBILAN Mvog-Ada Centre',
            'status' => 'temporarily_closed',
            'is_active' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($agency->fresh())
        ->name_fr->toBe('GS AUTOBILAN Mvog-Ada Centre')
        ->status->toBe('temporarily_closed')
        ->is_active->toBeFalse();

    Livewire::test(EditAgency::class, ['record' => $agency->id])
        ->callAction(DeleteAction::class);

    expect(Agency::query()->whereKey($agency->id)->exists())->toBeFalse();
});

it('scopes agency admins to their assigned agency resource records', function () {
    $agency = s051Agency('nkolbisson', 1);
    $otherAgency = s051Agency('obili-scalom', 2);
    $agencyAdmin = s051User('agency_admin', $agency);

    s051ActingAs($agencyAdmin);

    $this->get('/admin/agencies')->assertOk();
    $this->get('/admin/agencies/create')->assertForbidden();
    $this->get("/admin/agencies/{$agency->id}/edit")->assertForbidden();

    expect(AgencyResource::getEloquentQuery()->pluck('id')->all())
        ->toBe([$agency->id])
        ->not->toContain($otherAgency->id);

    Livewire::test(ListAgencies::class)
        ->assertCanSeeTableRecords([$agency])
        ->assertCanNotSeeTableRecords([$otherAgency]);
});

it('allows content managers to create and edit services from Filament', function () {
    s051ActingAs(s051User('content_manager'));

    Livewire::test(CreateService::class)
        ->fillForm(s051ServicePayload('fleet-control'))
        ->call('create')
        ->assertHasNoFormErrors();

    $service = Service::query()->where('slug_fr', 'controle-flottes-fleet-control')->firstOrFail();

    expect($service)
        ->title_fr->toBe('Controle flottes fleet-control')
        ->is_active->toBeTrue();

    Livewire::test(EditService::class, ['record' => $service->id])
        ->fillForm([
            'title_en' => 'Fleet inspection updated',
            'sort_order' => 4,
            'is_active' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($service->fresh())
        ->title_en->toBe('Fleet inspection updated')
        ->sort_order->toBe(4)
        ->is_active->toBeFalse();

    Livewire::test(EditService::class, ['record' => $service->id])
        ->callAction(DeleteAction::class);

    expect(Service::query()->whereKey($service->id)->exists())->toBeFalse();
});

it('keeps service resources unavailable to agency admins', function () {
    s051ActingAs(s051User('agency_admin', s051Agency('nkolbisson', 1)));

    expect(ServiceResource::canAccess())->toBeFalse();

    $this->get('/admin/services')->assertForbidden();
    $this->get('/admin/services/create')->assertForbidden();
});

function s051ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s051User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

/**
 * @return array<string, mixed>
 */
function s051AgencyPayload(string $slug): array
{
    return [
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug,
        'status' => 'operational',
        'is_active' => true,
        'sort_order' => 3,
        'phones' => ['+237678000001', '+237678000002'],
        'whatsapp' => '+237678000001',
        'email' => $slug.'@example.test',
        'map_link' => 'https://maps.example.test/'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'description_fr' => 'Agence de controle technique.',
        'description_en' => 'Technical inspection agency.',
    ];
}

function s051Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        ...s051AgencyPayload($slug),
        'sort_order' => $sortOrder,
    ]);
}

/**
 * @return array<string, mixed>
 */
function s051ServicePayload(string $suffix): array
{
    return [
        'title_fr' => 'Controle flottes '.$suffix,
        'title_en' => 'Fleet inspection '.$suffix,
        'slug_fr' => 'controle-flottes-'.$suffix,
        'slug_en' => 'fleet-inspection-'.$suffix,
        'short_description_fr' => 'Controle technique pour flottes.',
        'short_description_en' => 'Technical inspection for fleets.',
        'full_description_fr' => 'Description longue FR.',
        'full_description_en' => 'Long EN description.',
        'icon' => 'truck',
        'image' => null,
        'sort_order' => 2,
        'is_active' => true,
    ];
}
