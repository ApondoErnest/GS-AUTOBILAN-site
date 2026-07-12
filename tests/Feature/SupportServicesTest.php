<?php

use App\Enums\ArticleStatus;
use App\Enums\ContactStatus;
use App\Enums\GalleryCategory;
use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Services\ContactMessageService;
use App\Services\ContentService;
use App\Services\SEOService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('stores public contact messages with the default new status', function () {
    $agency = s044Agency();

    $message = app(ContactMessageService::class)->create([
        'name' => 'Client Contact',
        'phone' => '+237677000000',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'internal_notes' => 'This must not be accepted from public input.',
        'status' => ContactStatus::Closed,
    ]);

    expect($message)->toBeInstanceOf(ContactMessage::class);
    expect($message->status)->toBe(ContactStatus::New);
    expect($message->agency->is($agency))->toBeTrue();
    expect($message->internal_notes)->toBeNull();
    expect($message->assigned_user_id)->toBeNull();

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Client Contact',
        'subject' => 'Renseignement',
        'status' => ContactStatus::New->value,
        'agency_id' => $agency->id,
    ]);
});

it('can assign agencies and mark contact messages as spam', function () {
    $agency = s044Agency();
    $message = ContactMessage::query()->create([
        'name' => 'Client Contact',
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'status' => ContactStatus::New,
    ]);

    $service = app(ContactMessageService::class);

    expect($service->assignAgency($message, $agency->id)->agency_id)->toBe($agency->id);
    expect($service->markSpam($message)->status)->toBe(ContactStatus::Spam);
});

it('returns active bilingual content and falls back between locales', function () {
    Carbon::setTestNow('2026-07-11 12:00:00');
    $agency = s044Agency();
    $category = ArticleCategory::query()->create([
        'name_fr' => 'Conseils',
        'name_en' => 'Advice',
        'slug_fr' => 'conseils',
        'slug_en' => 'advice',
        'sort_order' => 1,
    ]);

    $published = Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite',
        'slug_en' => 'prepare-your-visit',
        'summary_fr' => 'Resume disponible en francais.',
        'summary_en' => null,
        'content_fr' => 'Contenu FR.',
        'content_en' => 'EN content.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Brouillon',
        'title_en' => 'Draft',
        'slug_fr' => 'brouillon',
        'slug_en' => 'draft',
        'content_fr' => 'Brouillon FR.',
        'content_en' => 'Draft EN.',
        'status' => ArticleStatus::Draft,
    ]);

    Faq::query()->create([
        'question_fr' => 'Question active ?',
        'question_en' => 'Active question?',
        'answer_fr' => 'Oui.',
        'answer_en' => 'Yes.',
        'sort_order' => 1,
    ]);

    Faq::query()->create([
        'question_fr' => 'Question inactive ?',
        'question_en' => 'Inactive question?',
        'answer_fr' => 'Non.',
        'answer_en' => 'No.',
        'is_active' => false,
        'sort_order' => 2,
    ]);

    GalleryItem::query()->create([
        'caption_fr' => 'Reception',
        'caption_en' => 'Reception',
        'agency_id' => $agency->id,
        'category' => GalleryCategory::Reception,
        'image_path' => 'gallery/reception.jpg',
        'sort_order' => 1,
    ]);

    Testimonial::query()->create([
        'customer_name' => 'Client satisfait',
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service rapide.',
        'message_en' => 'Fast service.',
        'rating' => 5,
        'sort_order' => 1,
    ]);

    $content = app(ContentService::class);

    expect($content->publishedArticles())->toHaveCount(1);
    expect($content->publishedArticles()->first()->is($published))->toBeTrue();
    expect($content->articleBySlug('prepare-your-visit', 'en')->is($published))->toBeTrue();
    expect($content->activeArticleCategories())->toHaveCount(1);
    expect($content->activeFaqs())->toHaveCount(1);
    expect($content->activeGalleryItems())->toHaveCount(1);
    expect($content->activeTestimonials())->toHaveCount(1);
    expect($content->localized($published, 'summary', 'en'))->toBe('Resume disponible en francais.');

    $sections = $content->homepageSections();

    expect(array_keys($sections))->toBe(['articles', 'faqs', 'gallery', 'testimonials']);
    expect($sections['articles'])->toHaveCount(1);
});

it('builds SEO metadata from settings with canonical and hreflang links', function () {
    Setting::query()->create([
        'key' => 'seo_defaults',
        'value' => [
            'title_fr' => 'GS AUTOBILAN - Centre de visite technique automobile',
            'title_en' => 'GS AUTOBILAN - Vehicle technical inspection centre',
            'description_fr' => 'Reservation et suivi de rendez-vous a Yaounde.',
            'description_en' => 'Booking and appointment tracking in Yaounde.',
        ],
    ]);

    $seo = app(SEOService::class);
    $meta = $seo->forRoute('home', locale: 'fr');

    expect($meta['title'])->toBe('GS AUTOBILAN - Centre de visite technique automobile');
    expect($meta['description'])->toBe('Reservation et suivi de rendez-vous a Yaounde.');
    expect($meta['og']['title'])->toBe($meta['title']);
    expect($meta['canonical'])->toContain('/fr/accueil');
    expect($meta['hreflang']['fr'])->toContain('/fr/accueil');
    expect($meta['hreflang']['en'])->toContain('/en/home');

    $custom = $seo->meta('en', [
        'title' => 'Custom title',
        'canonical' => 'https://example.test/custom',
        'hreflang' => ['en' => 'https://example.test/custom'],
    ]);

    expect($custom['title'])->toBe('Custom title');
    expect($custom['description'])->toBe('Booking and appointment tracking in Yaounde.');
    expect($custom['canonical'])->toBe('https://example.test/custom');
    expect($custom['hreflang'])->toBe(['en' => 'https://example.test/custom']);
});

function s044Agency(): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 'nkolbisson',
        'address_fr' => 'Carrefour Onana',
        'address_en' => 'Onana junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => 'nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
    ]);
}
