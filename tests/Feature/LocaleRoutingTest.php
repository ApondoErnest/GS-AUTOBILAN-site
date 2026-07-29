<?php

use App\Enums\ArticleStatus;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects the root path to the default French home page', function () {
    $this->get('/')->assertRedirect('/fr/accueil');
});

it('renders the French home page with French locale links', function () {
    $this->get('/fr/accueil')
        ->assertOk()
        ->assertSee('Votre sécurité', false)
        ->assertSee('href="/fr/rendez-vous"', false)
        ->assertSee('href="/fr/suivi-rendez-vous"', false)
        ->assertSee('lg:sticky lg:top-0', false)
        ->assertSee('data-back-to-top', false)
        ->assertSee('Retour en haut', false)
        ->assertDontSee('gs-fabs', false)
        ->assertSee('href="/en/home"', false);
});

it('renders the English home page with English locale links', function () {
    $this->get('/en/home')
        ->assertOk()
        ->assertSee('Your safety is our profession.', false)
        ->assertSee('href="/en/booking"', false)
        ->assertSee('href="/en/appointment-tracking"', false)
        ->assertSee('href="/fr/accueil"', false);
});

it('keeps the current public page when switching languages', function () {
    $this->get('/fr/a-propos')
        ->assertOk()
        ->assertSee('href="/fr/a-propos"', false)
        ->assertSee('href="/en/about"', false)
        ->assertDontSee('href="/en/home"', false);

    $this->get('/en/about')
        ->assertOk()
        ->assertSee('href="/en/about"', false)
        ->assertSee('href="/fr/a-propos"', false)
        ->assertDontSee('href="/fr/accueil"', false);

    $this->get('/fr/nos-agences')
        ->assertOk()
        ->assertSee('href="/fr/nos-agences"', false)
        ->assertSee('href="/en/our-agencies"', false)
        ->assertDontSee('href="/en/home"', false);

    $this->get('/en/our-agencies')
        ->assertOk()
        ->assertSee('href="/en/our-agencies"', false)
        ->assertSee('href="/fr/nos-agences"', false)
        ->assertDontSee('href="/fr/accueil"', false);
});

it('keeps French and English UI translation files structurally aligned', function () {
    $frenchFiles = collect(glob(lang_path('fr/*.php')))
        ->map(fn (string $path): string => basename($path))
        ->sort()
        ->values();
    $englishFiles = collect(glob(lang_path('en/*.php')))
        ->map(fn (string $path): string => basename($path))
        ->sort()
        ->values();

    expect($englishFiles->all())->toBe($frenchFiles->all());

    foreach ($frenchFiles as $file) {
        $frenchKeys = s071TranslationLeafKeys(require lang_path('fr/'.$file));
        $englishKeys = s071TranslationLeafKeys(require lang_path('en/'.$file));

        sort($frenchKeys);
        sort($englishKeys);

        expect($englishKeys)->toBe($frenchKeys, "Translation keys drifted in {$file}");
    }
});

it('registers the localized public route skeletons', function () {
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
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $this->get('/fr/contact')->assertOk()->assertSee('Contact', false);
    $this->get('/en/contact')->assertOk()->assertSee('Contact', false);
    $this->get('/fr/actualites/preparer-sa-visite')->assertOk();
    $this->get('/en/news/prepare-your-visit')->assertOk();
});

it('does not match unsupported locale prefixes', function () {
    $this->get('/de/home')->assertNotFound();
});

function s071TranslationLeafKeys(array $translations, string $prefix = ''): array
{
    $keys = [];

    foreach ($translations as $key => $value) {
        $leaf = $prefix === '' ? (string) $key : $prefix.'.'.$key;

        if (is_array($value)) {
            array_push($keys, ...s071TranslationLeafKeys($value, $leaf));

            continue;
        }

        $keys[] = $leaf;
    }

    return $keys;
}
