<?php

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

it('renders SEO metadata on placeholder article routes until S064 builds article pages', function () {
    $routes = [
        'fr' => '/fr/actualites/preparer-sa-visite',
        'en' => '/en/news/prepare-your-visit',
    ];

    foreach ($routes as $locale => $uri) {
        $html = $this->get($uri)
            ->assertOk()
            ->getContent();

        $title = trans('news.article_meta_title', [], $locale);
        $description = trans('news.article_meta_description', [], $locale);

        $this->assertStringContainsString('<title>'.e($title).'</title>', $html);
        $this->assertStringContainsString('<meta name="description" content="'.e($description).'">', $html);
        $this->assertStringContainsString('<link rel="canonical" href="'.url($uri).'">', $html);
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
