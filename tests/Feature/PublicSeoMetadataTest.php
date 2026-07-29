<?php

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('renders per-page bilingual SEO metadata with canonicals and hreflang alternates', function () {
    foreach (s074SeoPages() as $pageName => $page) {
        foreach (['fr', 'en'] as $locale) {
            $html = $this->get($page[$locale]['uri'])
                ->assertOk()
                ->getContent();

            $title = trans($page['title'], [], $locale);
            $description = trans($page['description'], [], $locale);

            $this->assertStringContainsString(
                '<title>'.e($title).'</title>',
                $html,
                "{$pageName} is missing its {$locale} SEO title.",
            );
            $this->assertStringContainsString(
                '<meta name="description" content="'.e($description).'">',
                $html,
                "{$pageName} is missing its {$locale} meta description.",
            );
            $this->assertStringContainsString(
                '<link rel="canonical" href="'.url($page[$locale]['uri']).'">',
                $html,
                "{$pageName} is missing its {$locale} canonical URL.",
            );
            $this->assertStringContainsString(
                '<link rel="alternate" hreflang="fr" href="'.url($page['fr']['uri']).'">',
                $html,
                "{$pageName} is missing its French hreflang alternate.",
            );
            $this->assertStringContainsString(
                '<link rel="alternate" hreflang="en" href="'.url($page['en']['uri']).'">',
                $html,
                "{$pageName} is missing its English hreflang alternate.",
            );
            $this->assertStringContainsString(
                '<link rel="alternate" hreflang="x-default" href="'.url($page['fr']['uri']).'">',
                $html,
                "{$pageName} is missing its x-default hreflang alternate.",
            );
            $this->assertStringContainsString(
                '<meta property="og:title" content="'.e($title).'">',
                $html,
                "{$pageName} is missing its {$locale} OpenGraph title.",
            );
            $this->assertStringContainsString(
                '<meta property="og:description" content="'.e($description).'">',
                $html,
                "{$pageName} is missing its {$locale} OpenGraph description.",
            );
        }
    }
});

it('renders SEO metadata on S064 published article detail routes', function () {
    $category = ArticleCategory::query()->create([
        'name_fr' => 'Conseils',
        'name_en' => 'Advice',
        'slug_fr' => 'conseils',
        'slug_en' => 'advice',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Préparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite',
        'slug_en' => 'prepare-your-visit',
        'summary_fr' => 'Résumé public.',
        'summary_en' => 'Public summary.',
        'content_fr' => 'Contenu public.',
        'content_en' => 'Public content.',
        'meta_title_fr' => 'Préparer sa visite · GS AUTOBILAN',
        'meta_title_en' => 'Prepare your visit · GS AUTOBILAN',
        'meta_description_fr' => 'Conseils pour préparer votre visite technique.',
        'meta_description_en' => 'Advice to prepare your technical inspection.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    foreach ([
        'fr' => [
            'uri' => '/fr/actualites/preparer-sa-visite',
            'title' => 'Préparer sa visite · GS AUTOBILAN',
            'description' => 'Conseils pour préparer votre visite technique.',
            'alternate' => url('/en/news/prepare-your-visit'),
        ],
        'en' => [
            'uri' => '/en/news/prepare-your-visit',
            'title' => 'Prepare your visit · GS AUTOBILAN',
            'description' => 'Advice to prepare your technical inspection.',
            'alternate' => url('/fr/actualites/preparer-sa-visite'),
        ],
    ] as $locale => $page) {
        $html = $this->get($page['uri'])
            ->assertOk()
            ->getContent();

        $this->assertStringContainsString('<title>'.e($page['title']).'</title>', $html);
        $this->assertStringContainsString('<meta name="description" content="'.e($page['description']).'">', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url($page['uri']).'">', $html);
        $this->assertStringContainsString('<link rel="alternate" hreflang="'.($locale === 'fr' ? 'en' : 'fr').'" href="'.$page['alternate'].'">', $html);
    }
});

/**
 * @return array<string, array{title: string, description: string, fr: array{uri: string}, en: array{uri: string}}>
 */
function s074SeoPages(): array
{
    return [
        'home' => [
            'title' => 'chrome.home_title',
            'description' => 'chrome.home_meta_description',
            'fr' => ['uri' => '/fr/accueil'],
            'en' => ['uri' => '/en/home'],
        ],
        'about' => [
            'title' => 'about.meta_title',
            'description' => 'about.meta_description',
            'fr' => ['uri' => '/fr/a-propos'],
            'en' => ['uri' => '/en/about'],
        ],
        'agencies' => [
            'title' => 'agencies.meta_title',
            'description' => 'agencies.meta_description',
            'fr' => ['uri' => '/fr/nos-agences'],
            'en' => ['uri' => '/en/our-agencies'],
        ],
        'services' => [
            'title' => 'services.meta_title',
            'description' => 'services.meta_description',
            'fr' => ['uri' => '/fr/services'],
            'en' => ['uri' => '/en/services'],
        ],
        'tariffs' => [
            'title' => 'tariffs.meta_title',
            'description' => 'tariffs.meta_description',
            'fr' => ['uri' => '/fr/tarifs'],
            'en' => ['uri' => '/en/tariffs'],
        ],
        'technical_inspection' => [
            'title' => 'inspection.meta_title',
            'description' => 'inspection.meta_description',
            'fr' => ['uri' => '/fr/visite-technique'],
            'en' => ['uri' => '/en/technical-inspection'],
        ],
        'booking' => [
            'title' => 'booking.meta_title',
            'description' => 'booking.meta_description',
            'fr' => ['uri' => '/fr/rendez-vous'],
            'en' => ['uri' => '/en/booking'],
        ],
        'tracking' => [
            'title' => 'tracking.meta_title',
            'description' => 'tracking.meta_description',
            'fr' => ['uri' => '/fr/suivi-rendez-vous'],
            'en' => ['uri' => '/en/appointment-tracking'],
        ],
        'news' => [
            'title' => 'news.meta_title',
            'description' => 'news.meta_description',
            'fr' => ['uri' => '/fr/actualites'],
            'en' => ['uri' => '/en/news'],
        ],
        'contact' => [
            'title' => 'contact.meta_title',
            'description' => 'contact.meta_description',
            'fr' => ['uri' => '/fr/contact'],
            'en' => ['uri' => '/en/contact'],
        ],
    ];
}
