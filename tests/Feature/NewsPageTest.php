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

it('renders the S064 published news listing in French with category filters', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');
    [$advice, $news] = s064NewsContent();

    $this->get('/fr/actualites')
        ->assertOk()
        ->assertSee('data-news-index', false)
        ->assertSee('Actualités &amp; Conseils', false)
        ->assertSee('Préparez votre visite technique avec les bons repères', false)
        ->assertSee('Dernières publications', false)
        ->assertSee('Tous les articles', false)
        ->assertSee('Conseils', false)
        ->assertSee('Actualités', false)
        ->assertSee('Préparer sa visite technique', false)
        ->assertSee('Documents utiles avant la visite', false)
        ->assertSee('/storage/articles/useful-docs.jpg', false)
        ->assertSee('href="/fr/actualites/preparer-sa-visite-technique"', false)
        ->assertSee('href="/fr/actualites?category='.$advice->slug_fr.'"', false)
        ->assertSee('href="/fr/actualites?category='.$news->slug_fr.'"', false)
        ->assertDontSee('Brouillon interne', false)
        ->assertDontSee('Publication future', false)
        ->assertDontSee('min-h-[60vh] bg-gs-wall', false);
});

it('filters the S064 published news listing in English', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');
    [$advice] = s064NewsContent();

    $this->get('/en/news?category='.$advice->slug_en)
        ->assertOk()
        ->assertSee('data-news-index', false)
        ->assertSee('News &amp; Advice', false)
        ->assertSee('Prepare your technical inspection with the right guidance', false)
        ->assertSee('Advice', false)
        ->assertSee('Prepare your technical inspection', false)
        ->assertSee('Useful documents before your visit', false)
        ->assertDontSee('Centre updates', false)
        ->assertSee('href="/en/news/prepare-your-technical-inspection"', false)
        ->assertSee('href="/fr/actualites?category='.$advice->slug_fr.'"', false)
        ->assertDontSee('Internal draft', false)
        ->assertDontSee('Future publication', false);

    $this->get('/fr/actualites?category='.$advice->slug_fr)
        ->assertOk()
        ->assertSee('href="/en/news?category='.$advice->slug_en.'"', false);
});

it('renders localized S064 article detail pages with SEO alternates and related content', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');
    s064NewsContent();

    $this->get('/fr/actualites/preparer-sa-visite-technique')
        ->assertOk()
        ->assertSee('data-news-article', false)
        ->assertSee('Préparer sa visite technique', false)
        ->assertSee('Organisez vos documents et votre véhicule avant de venir en agence.', false)
        ->assertSee('Vérifiez vos documents originaux avant le déplacement.', false)
        ->assertSee('Articles liés', false)
        ->assertSee('Documents utiles avant la visite', false)
        ->assertSee('href="/en/news/prepare-your-technical-inspection"', false)
        ->assertSee('<link rel="canonical" href="'.route('fr.article.show', ['slug' => 'preparer-sa-visite-technique']).'">', false)
        ->assertSee('<link rel="alternate" hreflang="en" href="'.route('en.article.show', ['slug' => 'prepare-your-technical-inspection']).'">', false)
        ->assertDontSee('Internal draft', false)
        ->assertDontSee('Future publication', false);

    $this->get('/en/news/prepare-your-technical-inspection')
        ->assertOk()
        ->assertSee('Prepare your technical inspection', false)
        ->assertSee('Check your original documents before travelling.', false)
        ->assertSee('Related articles', false)
        ->assertSee('Useful documents before your visit', false)
        ->assertSee('href="/fr/actualites/preparer-sa-visite-technique"', false)
        ->assertSee('<link rel="canonical" href="'.route('en.article.show', ['slug' => 'prepare-your-technical-inspection']).'">', false)
        ->assertSee('<link rel="alternate" hreflang="fr" href="'.route('fr.article.show', ['slug' => 'preparer-sa-visite-technique']).'">', false);

    $this->get('/en/news/useful-documents-before-your-visit')
        ->assertOk()
        ->assertSee('/storage/articles/useful-docs.jpg', false)
        ->assertSee('<meta property="og:image" content="'.asset('/storage/articles/useful-docs.jpg').'">', false);
});

it('returns not found for missing or unpublished S064 article slugs', function () {
    Carbon::setTestNow('2026-07-29 12:00:00');
    s064NewsContent();

    $this->get('/fr/actualites/brouillon-interne')->assertNotFound();
    $this->get('/en/news/future-publication')->assertNotFound();
    $this->get('/fr/actualites/article-inexistant')->assertNotFound();
});

/**
 * @return array{ArticleCategory, ArticleCategory}
 */
function s064NewsContent(): array
{
    $advice = ArticleCategory::query()->create([
        'name_fr' => 'Conseils',
        'name_en' => 'Advice',
        'slug_fr' => 'conseils',
        'slug_en' => 'advice',
        'sort_order' => 1,
        'is_active' => true,
    ]);
    $news = ArticleCategory::query()->create([
        'name_fr' => 'Actualités',
        'name_en' => 'News',
        'slug_fr' => 'actualites',
        'slug_en' => 'news',
        'sort_order' => 2,
        'is_active' => true,
    ]);

    Article::query()->create([
        'category_id' => $advice->id,
        'title_fr' => 'Préparer sa visite technique',
        'title_en' => 'Prepare your technical inspection',
        'slug_fr' => 'preparer-sa-visite-technique',
        'slug_en' => 'prepare-your-technical-inspection',
        'summary_fr' => 'Organisez vos documents et votre véhicule avant de venir en agence.',
        'summary_en' => 'Organize your documents and vehicle before visiting the agency.',
        'content_fr' => "Vérifiez vos documents originaux avant le déplacement.\n\nContrôlez les feux, les pneus et les essuie-glaces.",
        'content_en' => "Check your original documents before travelling.\n\nInspect lights, tyres, and wipers.",
        'featured_image' => 'images/homepage/prepare-visit.png',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    Article::query()->create([
        'category_id' => $advice->id,
        'title_fr' => 'Documents utiles avant la visite',
        'title_en' => 'Useful documents before your visit',
        'slug_fr' => 'documents-utiles-avant-la-visite',
        'slug_en' => 'useful-documents-before-your-visit',
        'summary_fr' => 'Gardez la carte grise, l’assurance et les anciens documents.',
        'summary_en' => 'Keep the registration card, insurance, and previous documents ready.',
        'content_fr' => 'Rangez les originaux dans un dossier facile à présenter.',
        'content_en' => 'Keep originals in a file that is easy to present.',
        'featured_image' => 'articles/useful-docs.jpg',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subHours(2),
    ]);

    Article::query()->create([
        'category_id' => $news->id,
        'title_fr' => 'Actualités du centre',
        'title_en' => 'Centre updates',
        'slug_fr' => 'actualites-du-centre',
        'slug_en' => 'centre-updates',
        'summary_fr' => 'Les dernières informations pratiques de nos agences.',
        'summary_en' => 'The latest practical information from our agencies.',
        'content_fr' => 'Nos équipes mettent à jour les informations utiles aux visiteurs.',
        'content_en' => 'Our teams keep useful visitor information up to date.',
        'featured_image' => 'images/homepage/quick-check.png',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subHours(3),
    ]);

    Article::query()->create([
        'category_id' => $news->id,
        'title_fr' => 'Brouillon interne',
        'title_en' => 'Internal draft',
        'slug_fr' => 'brouillon-interne',
        'slug_en' => 'internal-draft',
        'content_fr' => 'Non public.',
        'content_en' => 'Not public.',
        'status' => ArticleStatus::Draft,
    ]);

    Article::query()->create([
        'category_id' => $news->id,
        'title_fr' => 'Publication future',
        'title_en' => 'Future publication',
        'slug_fr' => 'publication-future',
        'slug_en' => 'future-publication',
        'content_fr' => 'Pas encore visible.',
        'content_en' => 'Not visible yet.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->addDay(),
    ]);

    return [$advice, $news];
}
