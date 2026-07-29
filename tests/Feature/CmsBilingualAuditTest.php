<?php

use App\Enums\ArticleStatus;
use App\Enums\GalleryCategory;
use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\Testimonial;
use App\Services\CmsBilingualAuditService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('passes when live CMS records have required bilingual content', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');

    s072CompleteCmsFixtures();

    Setting::query()->create([
        'key' => 'footer_cta',
        'value' => [
            'title_fr' => 'Besoin de programmer une visite ?',
            'title_en' => 'Need to schedule an inspection?',
            'links' => [
                [
                    'label_fr' => 'Appeler',
                    'label_en' => 'Call',
                ],
            ],
        ],
    ]);

    $audit = app(CmsBilingualAuditService::class);

    expect($audit->missingRequiredFields())->toBe([]);
    expect($audit->passes())->toBeTrue();
    expect($audit->requiredColumnMap()[Article::class])->toContain('summary_fr', 'summary_en');
});

it('reports missing bilingual fields only on live CMS records', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');

    $agency = s072Agency();
    $category = s072ArticleCategory();
    $publishedArticle = Article::query()->create(s072ArticlePayload($category, 'missing-summary', [
        'summary_en' => null,
    ]));

    Article::query()->create(s072ArticlePayload($category, 'draft-missing-summary', [
        'summary_en' => null,
        'status' => ArticleStatus::Draft,
        'published_at' => null,
    ]));

    Article::query()->create(s072ArticlePayload($category, 'future-missing-summary', [
        'summary_en' => null,
        'published_at' => now()->addDay(),
    ]));

    $activeGalleryItem = GalleryItem::query()->create(s072GalleryPayload($agency, 'gallery/live.jpg', [
        'caption_en' => ' ',
    ]));

    GalleryItem::query()->create(s072GalleryPayload($agency, 'gallery/inactive.jpg', [
        'caption_en' => null,
        'is_active' => false,
    ]));

    $activeTestimonial = Testimonial::query()->create(s072TestimonialPayload('Live client', [
        'customer_type_en' => null,
    ]));

    Testimonial::query()->create(s072TestimonialPayload('Inactive client', [
        'customer_type_en' => null,
        'is_active' => false,
    ]));

    $setting = Setting::query()->create([
        'key' => 'footer_cta',
        'value' => [
            'title_fr' => 'Nous joindre',
            'title_en' => ' ',
            'links' => [
                [
                    'label_fr' => 'Appeler',
                ],
            ],
        ],
    ]);

    $issues = app(CmsBilingualAuditService::class)->missingRequiredFields();
    $labels = array_column($issues, 'label');

    expect($labels)->toContain(
        "articles#{$publishedArticle->id}.summary_en",
        "gallery_items#{$activeGalleryItem->id}.caption_en",
        "testimonials#{$activeTestimonial->id}.customer_type_en",
        "settings#{$setting->id}.value.title_en",
        "settings#{$setting->id}.value.links.0.label_en",
    );
    expect($issues)->toHaveCount(5);
});

function s072CompleteCmsFixtures(): void
{
    $agency = s072Agency();
    $category = s072ArticleCategory();

    s072Service();
    s072Tariff();

    Article::query()->create(s072ArticlePayload($category, 'preparer-sa-visite'));

    Faq::query()->create([
        'question_fr' => 'La reservation est-elle automatique ?',
        'question_en' => 'Is booking automatic?',
        'answer_fr' => 'Non, notre equipe confirme le rendez-vous.',
        'answer_en' => 'No, our team confirms the appointment.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    GalleryItem::query()->create(s072GalleryPayload($agency, 'gallery/reception.jpg'));
    Testimonial::query()->create(s072TestimonialPayload('Client satisfait'));
}

function s072Agency(string $slug = 'nkolbisson'): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => $slug,
        'address_fr' => 'Carrefour Onana',
        'address_en' => 'Onana junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => "{$slug}@example.test",
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'description_fr' => 'Agence de visite technique.',
        'description_en' => 'Technical inspection agency.',
        'is_active' => true,
    ]);
}

function s072Service(string $slug = 'vehicules-legers'): Service
{
    return Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => $slug,
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s072Tariff(string $category = 'light'): Tariff
{
    return Tariff::query()->create([
        'category' => $category,
        'vehicle_type_fr' => 'Vehicules legers',
        'vehicle_type_en' => 'Light vehicles',
        'price' => null,
        'currency' => 'XAF',
        'notes_fr' => 'Tarif officiel en attente.',
        'notes_en' => 'Official tariff pending.',
        'sort_order' => 1,
        'is_active' => true,
        'is_placeholder' => true,
    ]);
}

function s072ArticleCategory(string $slug = 'conseils'): ArticleCategory
{
    return ArticleCategory::query()->create([
        'name_fr' => 'Conseils',
        'name_en' => 'Advice',
        'slug_fr' => $slug,
        'slug_en' => 'advice',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function s072ArticlePayload(ArticleCategory $category, string $slug, array $overrides = []): array
{
    return [
        'category_id' => $category->id,
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => $slug,
        'slug_en' => "{$slug}-en",
        'summary_fr' => 'Resume disponible en francais.',
        'summary_en' => 'English summary available.',
        'content_fr' => 'Contenu FR.',
        'content_en' => 'EN content.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
        ...$overrides,
    ];
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function s072GalleryPayload(Agency $agency, string $imagePath, array $overrides = []): array
{
    return [
        'caption_fr' => 'Reception',
        'caption_en' => 'Reception',
        'agency_id' => $agency->id,
        'category' => GalleryCategory::Reception,
        'image_path' => $imagePath,
        'sort_order' => 1,
        'is_active' => true,
        ...$overrides,
    ];
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function s072TestimonialPayload(string $customerName, array $overrides = []): array
{
    return [
        'customer_name' => $customerName,
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service rapide.',
        'message_en' => 'Fast service.',
        'rating' => 5,
        'sort_order' => 1,
        'is_active' => true,
        ...$overrides,
    ];
}
