<?php

use App\Enums\GalleryCategory;
use App\Filament\Resources\ActivityResource;
use App\Filament\Resources\ActivityResource\Pages\ListActivities;
use App\Filament\Resources\GalleryItemResource;
use App\Filament\Resources\GalleryItemResource\Pages\CreateGalleryItem;
use App\Filament\Resources\GalleryItemResource\Pages\EditGalleryItem;
use App\Filament\Resources\GalleryItemResource\Pages\ListGalleryItems;
use App\Filament\Resources\SettingResource;
use App\Filament\Resources\SettingResource\Pages\CreateSetting;
use App\Filament\Resources\SettingResource\Pages\EditSetting;
use App\Filament\Resources\TestimonialResource;
use App\Filament\Resources\TestimonialResource\Pages\CreateTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\EditTestimonial;
use App\Filament\Resources\TestimonialResource\Pages\ListTestimonials;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Models\Agency;
use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

it('registers the S055 final admin resources on the admin panel', function () {
    expect(Filament::getPanel('admin')->getResources())
        ->toContain(
            GalleryItemResource::class,
            TestimonialResource::class,
            UserResource::class,
            SettingResource::class,
            ActivityResource::class,
        );
});

it('allows content managers to create, update, and delete gallery items', function () {
    Storage::fake('public');

    $agency = s055Agency('nkolbisson', 1);

    s055ActingAs(s055User('content_manager'));

    Livewire::test(CreateGalleryItem::class)
        ->fillForm([
            'image_path' => UploadedFile::fake()->image('reception.jpg'),
            'category' => GalleryCategory::Reception->value,
            'agency_id' => $agency->id,
            'caption_fr' => 'Reception Nkolbisson',
            'caption_en' => 'Nkolbisson reception',
            'sort_order' => 2,
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $galleryItem = GalleryItem::query()->where('caption_fr', 'Reception Nkolbisson')->firstOrFail();

    expect($galleryItem)
        ->category->toBe(GalleryCategory::Reception)
        ->agency_id->toBe($agency->id)
        ->is_active->toBeTrue();

    Livewire::test(ListGalleryItems::class)
        ->assertCanSeeTableRecords([$galleryItem])
        ->assertTableColumnFormattedStateSet('category', 'Reception', $galleryItem);

    Livewire::test(EditGalleryItem::class, ['record' => $galleryItem->id])
        ->fillForm([
            'caption_fr' => 'Reception principale',
            'is_active' => false,
            'sort_order' => 4,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($galleryItem->fresh())
        ->caption_fr->toBe('Reception principale')
        ->is_active->toBeFalse()
        ->sort_order->toBe(4);

    Livewire::test(EditGalleryItem::class, ['record' => $galleryItem->id])
        ->callAction(DeleteAction::class);

    expect(GalleryItem::query()->whereKey($galleryItem->id)->exists())->toBeFalse();
});

it('allows content managers to create, update, and delete testimonials', function () {
    s055ActingAs(s055User('content_manager'));

    Livewire::test(CreateTestimonial::class)
        ->fillForm(s055TestimonialPayload('Client S055'))
        ->call('create')
        ->assertHasNoFormErrors();

    $testimonial = Testimonial::query()->where('customer_name', 'Client S055')->firstOrFail();

    expect($testimonial)
        ->rating->toBe(5)
        ->is_active->toBeTrue();

    Livewire::test(ListTestimonials::class)
        ->assertCanSeeTableRecords([$testimonial]);

    Livewire::test(EditTestimonial::class, ['record' => $testimonial->id])
        ->fillForm([
            'rating' => 4,
            'is_active' => false,
            'message_fr' => 'Service professionnel et rapide.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($testimonial->fresh())
        ->rating->toBe(4)
        ->is_active->toBeFalse()
        ->message_fr->toBe('Service professionnel et rapide.');

    Livewire::test(EditTestimonial::class, ['record' => $testimonial->id])
        ->callAction(DeleteAction::class);

    expect(Testimonial::query()->whereKey($testimonial->id)->exists())->toBeFalse();
});

it('allows super admins to manage staff users and sync roles', function () {
    $agency = s055Agency('obili-scalom', 1);

    s055ActingAs(s055User('super_admin'));

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Agency Staff S055',
            'email' => 'agency-staff-s055@example.test',
            'password' => 'secret-password',
            'assigned_agency_id' => $agency->id,
            'is_active' => true,
            'roles' => ['agency_admin'],
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $staff = User::query()->where('email', 'agency-staff-s055@example.test')->firstOrFail();

    expect(Hash::check('secret-password', $staff->password))->toBeTrue()
        ->and($staff->hasRole('agency_admin'))->toBeTrue()
        ->and($staff->assigned_agency_id)->toBe($agency->id);

    Livewire::test(EditUser::class, ['record' => $staff->id])
        ->fillForm([
            'name' => 'Content Staff S055',
            'assigned_agency_id' => null,
            'is_active' => false,
            'roles' => ['content_manager'],
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $staff = $staff->fresh();

    expect($staff)
        ->name->toBe('Content Staff S055')
        ->assigned_agency_id->toBeNull()
        ->is_active->toBeFalse()
        ->and($staff->hasRole('content_manager'))->toBeTrue()
        ->and($staff->hasRole('agency_admin'))->toBeFalse();

    Livewire::test(EditUser::class, ['record' => $staff->id])
        ->callAction(DeleteAction::class);

    expect(User::query()->whereKey($staff->id)->exists())->toBeFalse();
});

it('allows super admins to manage structured JSON settings', function () {
    s055ActingAs(s055User('super_admin'));

    Livewire::test(CreateSetting::class)
        ->fillForm([
            'key' => 'footer_cta',
            'value_json' => json_encode([
                'title_fr' => 'Pret pour la visite ?',
                'title_en' => 'Ready for inspection?',
                'actions' => ['booking', 'tracking'],
            ], JSON_PRETTY_PRINT),
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $setting = Setting::query()->where('key', 'footer_cta')->firstOrFail();

    expect($setting->value)
        ->title_fr->toBe('Pret pour la visite ?')
        ->actions->toBe(['booking', 'tracking']);

    Livewire::test(EditSetting::class, ['record' => $setting->id])
        ->fillForm([
            'value_json' => json_encode([
                'title_fr' => 'Votre vehicule est pret ?',
                'title_en' => 'Is your vehicle ready?',
                'actions' => ['booking'],
            ], JSON_PRETTY_PRINT),
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($setting->fresh()->value)
        ->title_fr->toBe('Votre vehicule est pret ?')
        ->actions->toBe(['booking']);
});

it('shows audit logs to super admins as a read-only resource', function () {
    $superAdmin = s055User('super_admin');
    $setting = Setting::query()->create([
        'key' => 'audit_test',
        'value' => ['enabled' => true],
    ]);

    Activity::query()->create([
        'log_name' => 'settings',
        'description' => 'Setting updated',
        'event' => 'updated',
        'subject_type' => Setting::class,
        'subject_id' => $setting->id,
        'causer_type' => User::class,
        'causer_id' => $superAdmin->id,
        'properties' => ['attributes' => ['enabled' => true]],
    ]);

    s055ActingAs($superAdmin);

    expect(ActivityResource::canAccess())->toBeTrue()
        ->and(ActivityResource::canCreate())->toBeFalse()
        ->and(ActivityResource::canDeleteAny())->toBeFalse();

    $this->get('/admin/audit')->assertOk();
    $this->get('/admin/audit/create')->assertNotFound();

    Livewire::test(ListActivities::class)
        ->assertCanSeeTableRecords(Activity::query()->get());
});

it('keeps S055 protected resources unavailable to unauthorized roles', function () {
    s055ActingAs(s055User('agency_admin', s055Agency('nkolbisson', 1)));

    expect(GalleryItemResource::canAccess())->toBeFalse();
    expect(TestimonialResource::canAccess())->toBeFalse();
    expect(UserResource::canAccess())->toBeFalse();
    expect(SettingResource::canAccess())->toBeFalse();
    expect(ActivityResource::canAccess())->toBeFalse();

    $this->get('/admin/gallery-items')->assertForbidden();
    $this->get('/admin/testimonials')->assertForbidden();
    $this->get('/admin/users')->assertForbidden();
    $this->get('/admin/settings')->assertForbidden();
    $this->get('/admin/audit')->assertForbidden();

    s055ActingAs(s055User('content_manager'));

    expect(GalleryItemResource::canAccess())->toBeTrue();
    expect(TestimonialResource::canAccess())->toBeTrue();
    expect(UserResource::canAccess())->toBeFalse();
    expect(SettingResource::canAccess())->toBeFalse();
    expect(ActivityResource::canAccess())->toBeFalse();

    $this->get('/admin/users')->assertForbidden();
    $this->get('/admin/settings')->assertForbidden();
    $this->get('/admin/audit')->assertForbidden();
});

function s055ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s055User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s055Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678000001'],
        'whatsapp' => '+237678000001',
        'email' => $slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

/**
 * @return array<string, mixed>
 */
function s055TestimonialPayload(string $customerName): array
{
    return [
        'customer_name' => $customerName,
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service rapide et conforme.',
        'message_en' => 'Fast and compliant service.',
        'rating' => 5,
        'image_path' => null,
        'sort_order' => 2,
        'is_active' => true,
    ];
}
