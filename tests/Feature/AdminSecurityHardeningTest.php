<?php

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Enums\GalleryCategory;
use App\Filament\Resources\GalleryItemResource\Pages\CreateGalleryItem;
use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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

it('rejects admin image uploads with disallowed mime types', function () {
    Storage::fake('public');

    $agency = s078Agency('nkolbisson');

    s078ActingAs(s078User('content_manager'));

    Livewire::test(CreateGalleryItem::class)
        ->fillForm(s078GalleryPayload(
            $agency,
            UploadedFile::fake()->create('payload.php', 12, 'application/x-php'),
        ))
        ->call('create')
        ->assertHasFormErrors(['image_path']);

    expect(GalleryItem::query()->count())->toBe(0);
});

it('rejects admin image uploads with unsafe original extensions', function () {
    Storage::fake('public');

    $agency = s078Agency('nkolbisson');

    s078ActingAs(s078User('content_manager'));

    Livewire::test(CreateGalleryItem::class)
        ->fillForm(s078GalleryPayload(
            $agency,
            UploadedFile::fake()->image('payload.php'),
        ))
        ->call('create')
        ->assertHasFormErrors(['image_path']);

    expect(GalleryItem::query()->count())->toBe(0);
});

it('rejects admin image uploads over the configured size limit', function () {
    Storage::fake('public');

    $agency = s078Agency('nkolbisson');

    s078ActingAs(s078User('content_manager'));

    Livewire::test(CreateGalleryItem::class)
        ->fillForm(s078GalleryPayload(
            $agency,
            UploadedFile::fake()->image('oversized.jpg')->size(2049),
        ))
        ->call('create')
        ->assertHasFormErrors(['image_path']);

    expect(GalleryItem::query()->count())->toBe(0);
});

it('stores accepted admin image uploads with server-generated filenames', function () {
    Storage::fake('public');

    $agency = s078Agency('nkolbisson');

    s078ActingAs(s078User('content_manager'));

    Livewire::test(CreateGalleryItem::class)
        ->fillForm(s078GalleryPayload(
            $agency,
            UploadedFile::fake()->image('reception.jpg')->size(512),
        ))
        ->call('create')
        ->assertHasNoFormErrors();

    $galleryItem = GalleryItem::query()->firstOrFail();

    expect($galleryItem->image_path)
        ->toStartWith('gallery/')
        ->not->toContain('reception.jpg')
        ->toMatch('/^gallery\/[0-9a-f-]{36}\.(jpg|png|webp)$/');

    Storage::disk('public')->assertExists($galleryItem->image_path);
});

it('logs key admin actions without recording sensitive user fields', function () {
    $admin = s078User('super_admin');
    $agency = s078Agency('obili-scalom');
    $service = s078Service();
    $category = s078ArticleCategory();

    s078ActingAs($admin);

    Activity::query()->delete();

    $booking = Booking::query()->create(s078BookingPayload($agency, $service));
    $booking->update([
        'status' => BookingStatus::Confirmed->value,
        'confirmed_date' => '2026-08-04',
        'confirmed_time_slot' => '10h00-11h00',
        'public_message' => 'Votre rendez-vous est confirme.',
        'internal_notes' => 'Confirme par telephone.',
    ]);

    $readiness = DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::NotReviewed->value,
    ]);
    $readiness->update([
        'status' => DocumentReadinessStatus::MissingInfo->value,
        'missing_information_note' => 'CNI manquante.',
        'updated_by' => $admin->id,
    ]);

    $article = Article::query()->create(s078ArticlePayload($category));
    $article->update([
        'status' => ArticleStatus::Published->value,
        'published_at' => '2026-08-04 10:30:00',
    ]);

    $setting = Setting::query()->create([
        'key' => 'audit_s078',
        'value' => ['enabled' => true],
    ]);
    $setting->update(['value' => ['enabled' => false]]);

    $staff = User::factory()->create([
        'name' => 'S078 Staff',
        'email' => 's078-staff@example.test',
        'is_active' => true,
    ]);
    $staff->update([
        'name' => 'S078 Staff Updated',
        'password' => 'changed-password',
        'is_active' => false,
    ]);

    foreach (['bookings', 'document_readiness', 'articles', 'settings', 'users'] as $logName) {
        expect(Activity::query()
            ->where('log_name', $logName)
            ->where('event', 'updated')
            ->where('causer_type', User::class)
            ->where('causer_id', $admin->id)
            ->exists())->toBeTrue();
    }

    expect(data_get(s078UpdatedActivityProperties('bookings', Booking::class, $booking->id), 'attributes.status'))
        ->toBe(BookingStatus::Confirmed->value)
        ->and(data_get(s078UpdatedActivityProperties('document_readiness', DocumentReadiness::class, $readiness->id), 'attributes.status'))
        ->toBe(DocumentReadinessStatus::MissingInfo->value)
        ->and(data_get(s078UpdatedActivityProperties('articles', Article::class, $article->id), 'attributes.status'))
        ->toBe(ArticleStatus::Published->value)
        ->and(data_get(s078UpdatedActivityProperties('settings', Setting::class, $setting->id), 'attributes.value.enabled'))
        ->toBeFalse();

    $userActivity = Activity::query()
        ->where('log_name', 'users')
        ->where('event', 'updated')
        ->where('subject_type', User::class)
        ->where('subject_id', $staff->id)
        ->latest('id')
        ->firstOrFail();

    $changes = $userActivity->attribute_changes->toArray();
    $changesJson = json_encode($changes, JSON_THROW_ON_ERROR);

    expect($changesJson)
        ->not->toContain('password')
        ->toContain('S078 Staff Updated');
});

function s078ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s078User(string $role): User
{
    $user = User::factory()->create();

    $user->assignRole($role);

    return $user->fresh();
}

/**
 * @return array<string, mixed>
 */
function s078UpdatedActivityProperties(string $logName, string $subjectType, int $subjectId): array
{
    return Activity::query()
        ->where('log_name', $logName)
        ->where('event', 'updated')
        ->where('subject_type', $subjectType)
        ->where('subject_id', $subjectId)
        ->latest('id')
        ->firstOrFail()
        ->attribute_changes
        ->toArray();
}

function s078Agency(string $slug): Agency
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
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s078Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Controle technique S078',
        'title_en' => 'Technical inspection S078',
        'slug_fr' => 'controle-technique-s078',
        'slug_en' => 'technical-inspection-s078',
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s078ArticleCategory(): ArticleCategory
{
    return ArticleCategory::query()->create([
        'name_fr' => 'Conseils S078',
        'name_en' => 'Advice S078',
        'slug_fr' => 'conseils-s078',
        'slug_en' => 'advice-s078',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

/**
 * @return array<string, mixed>
 */
function s078GalleryPayload(Agency $agency, UploadedFile $image): array
{
    return [
        'image_path' => $image,
        'category' => GalleryCategory::Reception->value,
        'agency_id' => $agency->id,
        'caption_fr' => 'Reception securisee',
        'caption_en' => 'Secure reception',
        'sort_order' => 1,
        'is_active' => true,
    ];
}

/**
 * @return array<string, mixed>
 */
function s078BookingPayload(Agency $agency, Service $service): array
{
    return [
        'reference' => 'GS-2026-078001',
        'customer_name' => 'Client S078',
        'phone' => '+237699078000',
        'whatsapp' => '+237699078000',
        'email' => 'client-s078@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE078AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'Light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-08-03',
        'preferred_time_slot' => '09h00-10h00',
        'status' => BookingStatus::NewRequest->value,
        'customer_message' => 'Verification documents.',
        'public_message' => null,
        'internal_notes' => null,
    ];
}

/**
 * @return array<string, mixed>
 */
function s078ArticlePayload(ArticleCategory $category): array
{
    return [
        'category_id' => $category->id,
        'status' => ArticleStatus::Draft->value,
        'title_fr' => 'Preparer sa visite S078',
        'title_en' => 'Prepare your visit S078',
        'slug_fr' => 'preparer-sa-visite-s078',
        'slug_en' => 'prepare-your-visit-s078',
        'summary_fr' => 'Resume FR.',
        'summary_en' => 'EN summary.',
        'content_fr' => 'Contenu long FR.',
        'content_en' => 'Long EN content.',
        'featured_image' => null,
        'published_at' => null,
        'meta_title_fr' => null,
        'meta_title_en' => null,
        'meta_description_fr' => null,
        'meta_description_en' => null,
    ];
}
