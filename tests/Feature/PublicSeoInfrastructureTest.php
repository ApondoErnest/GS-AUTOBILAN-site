<?php

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('renders a localized public sitemap with alternates and no admin URLs', function () {
    $xml = $this->get('/sitemap.xml')
        ->assertOk()
        ->tap(fn ($response) => expect(strtolower((string) $response->headers->get('content-type')))->toContain('text/xml'))
        ->getContent();

    $this->assertStringContainsString('<?xml version="1.0" encoding="UTF-8"?>', $xml);
    $this->assertStringContainsString('<urlset', $xml);
    $this->assertStringNotContainsString('/admin', $xml);

    foreach (s075LocalizedRouteNames() as $routeBaseName) {
        foreach (['fr', 'en'] as $locale) {
            $this->assertStringContainsString('<loc>'.route("{$locale}.{$routeBaseName}").'</loc>', $xml);
        }

        $this->assertStringContainsString('hreflang="fr" href="'.route("fr.{$routeBaseName}").'"', $xml);
        $this->assertStringContainsString('hreflang="en" href="'.route("en.{$routeBaseName}").'"', $xml);
        $this->assertStringContainsString('hreflang="x-default" href="'.route("fr.{$routeBaseName}").'"', $xml);
    }
});

it('adds published bilingual articles to the sitemap when they exist', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');

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
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite',
        'slug_en' => 'prepare-your-visit',
        'summary_fr' => 'Resume public.',
        'summary_en' => 'Public summary.',
        'content_fr' => 'Contenu public.',
        'content_en' => 'Public content.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Brouillon',
        'title_en' => 'Draft',
        'slug_fr' => 'brouillon',
        'slug_en' => 'draft',
        'content_fr' => 'Brouillon.',
        'content_en' => 'Draft.',
        'status' => ArticleStatus::Draft,
    ]);

    $xml = $this->get('/sitemap.xml')
        ->assertOk()
        ->getContent();

    $this->assertStringContainsString('<loc>'.route('fr.article.show', ['slug' => 'preparer-sa-visite']).'</loc>', $xml);
    $this->assertStringContainsString('<loc>'.route('en.article.show', ['slug' => 'prepare-your-visit']).'</loc>', $xml);
    $this->assertStringContainsString('hreflang="fr" href="'.route('fr.article.show', ['slug' => 'preparer-sa-visite']).'"', $xml);
    $this->assertStringContainsString('hreflang="en" href="'.route('en.article.show', ['slug' => 'prepare-your-visit']).'"', $xml);
    $this->assertStringNotContainsString('brouillon', $xml);
    $this->assertStringNotContainsString('draft', $xml);
});

it('serves robots.txt with admin disallowed and the sitemap URL', function () {
    $robots = $this->get('/robots.txt')
        ->assertOk()
        ->tap(fn ($response) => expect(strtolower((string) $response->headers->get('content-type')))->toContain('text/plain'))
        ->getContent();

    $this->assertStringContainsString('User-agent: *', $robots);
    $this->assertStringContainsString('Disallow: /admin', $robots);
    $this->assertStringContainsString('Sitemap: '.url('/sitemap.xml'), $robots);
});

it('renders LocalBusiness JSON-LD for each agency page card', function () {
    foreach (['/fr/nos-agences', '/en/our-agencies'] as $uri) {
        $html = $this->get($uri)
            ->assertOk()
            ->getContent();
        $schemas = s075JsonLdSchemas($html);

        expect($schemas)->toHaveCount(2);
        expect(collect($schemas)->pluck('@type')->all())->toBe(['LocalBusiness', 'LocalBusiness']);
        expect(collect($schemas)->pluck('name')->all())
            ->toContain('GS AUTOBILAN Nkolbisson')
            ->toContain('GS AUTOBILAN Obili Scalom');

        $nkolbisson = collect($schemas)->firstWhere('name', 'GS AUTOBILAN Nkolbisson');
        $obili = collect($schemas)->firstWhere('name', 'GS AUTOBILAN Obili Scalom');

        expect($nkolbisson['address']['addressCountry'])->toBe('CM');
        expect($nkolbisson['address']['addressLocality'])->toBe('Yaounde');
        expect($nkolbisson['geo']['latitude'])->toBe(3.8882487);
        expect($nkolbisson['geo']['longitude'])->toBe(11.4549352);
        expect($nkolbisson['telephone'])->toContain('+237 678 844 791');
        expect($obili['geo']['latitude'])->toBe(3.8471748);
        expect($obili['geo']['longitude'])->toBe(11.4967492);
    }
});

/**
 * @return list<string>
 */
function s075LocalizedRouteNames(): array
{
    return [
        'home',
        'about',
        'agencies',
        'services',
        'tariffs',
        'technical_inspection',
        'booking',
        'tracking',
        'news',
        'contact',
    ];
}

/**
 * @return list<array<string, mixed>>
 */
function s075JsonLdSchemas(string $html): array
{
    preg_match_all('/<script type="application\\/ld\\+json">(.*?)<\\/script>/s', $html, $matches);

    return collect($matches[1])
        ->map(fn (string $json): mixed => json_decode($json, true, flags: JSON_THROW_ON_ERROR))
        ->values()
        ->all();
}
