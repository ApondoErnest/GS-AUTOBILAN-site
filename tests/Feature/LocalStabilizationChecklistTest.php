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

it('keeps S086 completed public pages available and internally linked', function () {
    Carbon::setTestNow('2026-07-29 13:00:00');
    s086PublishedNews();

    $publicPages = [
        '/fr/accueil' => 'Centres professionnels de visite technique automobile à Yaoundé',
        '/en/home' => 'Professional vehicle technical inspection centres in Yaounde',
        '/fr/a-propos' => 'À propos de GS AUTOBILAN',
        '/en/about' => 'About GS AUTOBILAN',
        '/fr/nos-agences' => 'Trouvez votre agence',
        '/en/our-agencies' => 'Find your',
        '/fr/services' => 'Des services de visite technique pensés pour la sécurité',
        '/en/services' => 'Technical inspection services designed for safety',
        '/fr/tarifs' => 'Des tarifs clairs pour chaque catégorie de véhicule',
        '/en/tariffs' => 'Clear tariffs for every vehicle category',
        '/fr/visite-technique' => 'Comprendre et réussir votre visite technique',
        '/en/technical-inspection' => 'Understand and complete your technical inspection',
        '/fr/rendez-vous' => 'Demandez votre créneau de visite technique',
        '/en/booking' => 'Request your technical inspection visit slot',
        '/fr/suivi-rendez-vous' => 'Suivez votre demande de rendez-vous',
        '/en/appointment-tracking' => 'Track your appointment request',
        '/fr/actualites' => 'Préparez votre visite technique avec les bons repères',
        '/en/news' => 'Prepare your technical inspection with the right guidance',
        '/fr/actualites/stabilisation-locale' => 'Stabilisation locale',
        '/en/news/local-stabilization' => 'Local stabilization',
        '/fr/contact' => 'Que souhaitez-vous faire ?',
        '/en/contact' => 'What would you like to do?',
    ];

    $linksByTarget = [];

    foreach ($publicPages as $uri => $expectedCopy) {
        $html = $this->get($uri)
            ->assertOk()
            ->assertSee($expectedCopy, false)
            ->getContent();

        expect($html)
            ->not->toContain('Placeholder for home modules.')
            ->not->toContain('min-h-[60vh] bg-gs-wall');

        foreach (s086InternalLinks($html) as $href) {
            $linksByTarget[$href][] = $uri;
        }
    }

    foreach ($linksByTarget as $href => $sources) {
        $response = $this->get($href);

        $message = $href.' linked from '.implode(', ', array_unique($sources));

        test()->assertNotSame(404, $response->getStatusCode(), $message);
        test()->assertLessThan(500, $response->getStatusCode(), $message);
    }
});

/**
 * @return array<int, string>
 */
function s086InternalLinks(string $html): array
{
    preg_match_all('/\shref=(["\'])(.*?)\1/i', $html, $matches);

    return collect($matches[2] ?? [])
        ->map(fn (string $href): string => html_entity_decode(trim($href), ENT_QUOTES | ENT_HTML5))
        ->reject(fn (string $href): bool => $href === '' || str_starts_with($href, '#'))
        ->reject(fn (string $href): bool => preg_match('/^(?:mailto|tel|sms|javascript):/i', $href) === 1)
        ->map(function (string $href): ?string {
            $appUrl = url('/');

            if (str_starts_with($href, $appUrl)) {
                $href = substr($href, strlen($appUrl)) ?: '/';
            }

            if (preg_match('/^https?:\/\//i', $href) === 1 || str_starts_with($href, '//')) {
                return null;
            }

            $parts = parse_url($href);
            $path = $parts['path'] ?? '';

            if ($path === '' || ! str_starts_with($path, '/')) {
                return null;
            }

            if (preg_match('#^/(?:build|images|storage)/|^/(?:favicon|apple-touch-icon)|\.(?:css|js|ico|png|jpe?g|gif|svg|webp|avif|pdf)$#i', $path) === 1) {
                return null;
            }

            return $path.(filled($parts['query'] ?? null) ? '?'.$parts['query'] : '');
        })
        ->filter()
        ->unique()
        ->values()
        ->all();
}

function s086PublishedNews(): void
{
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
        'title_fr' => 'Stabilisation locale',
        'title_en' => 'Local stabilization',
        'slug_fr' => 'stabilisation-locale',
        'slug_en' => 'local-stabilization',
        'summary_fr' => 'Les pages publiques sont prêtes pour la validation locale.',
        'summary_en' => 'The public pages are ready for local validation.',
        'content_fr' => "Chaque page publique est disponible.\n\nLes liens internes sont vérifiés avant Docker.",
        'content_en' => "Every public page is available.\n\nInternal links are checked before Docker.",
        'featured_image' => 'images/homepage/prepare-visit.png',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Préparer le passage Docker',
        'title_en' => 'Prepare the Docker pass',
        'slug_fr' => 'preparer-le-passage-docker',
        'slug_en' => 'prepare-the-docker-pass',
        'summary_fr' => 'Une vérification de soutien pour les articles liés.',
        'summary_en' => 'A supporting check for related articles.',
        'content_fr' => 'Les articles liés restent publiés et localisés.',
        'content_en' => 'Related articles remain published and localized.',
        'featured_image' => 'images/homepage/necessary-docs.png',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subHours(2),
    ]);

    foreach ([
        [
            'title_fr' => 'Comment préparer votre véhicule pour la visite technique',
            'title_en' => 'How to prepare your vehicle for technical inspection',
            'slug_fr' => 'preparer-votre-vehicule-visite-technique',
            'slug_en' => 'prepare-your-vehicle-for-technical-inspection',
            'image' => 'images/homepage/prepare-visit.png',
        ],
        [
            'title_fr' => 'Documents nécessaires avant votre passage',
            'title_en' => 'Required documents before your visit',
            'slug_fr' => 'documents-necessaires-visite-technique',
            'slug_en' => 'required-documents-before-your-visit',
            'image' => 'images/homepage/necessary-docs.png',
        ],
        [
            'title_fr' => 'Que faire en cas de contre-visite ?',
            'title_en' => 'What to do in case of re-inspection?',
            'slug_fr' => 'que-faire-en-cas-de-contre-visite',
            'slug_en' => 'what-to-do-in-case-of-re-inspection',
            'image' => 'images/homepage/case-cv.png',
        ],
    ] as $index => $article) {
        Article::query()->create([
            'category_id' => $category->id,
            'title_fr' => $article['title_fr'],
            'title_en' => $article['title_en'],
            'slug_fr' => $article['slug_fr'],
            'slug_en' => $article['slug_en'],
            'summary_fr' => 'Conseil pratique avant la visite technique.',
            'summary_en' => 'Practical advice before the technical inspection.',
            'content_fr' => 'Ce conseil aide les visiteurs à préparer un passage plus fluide.',
            'content_en' => 'This advice helps visitors prepare for a smoother visit.',
            'featured_image' => $article['image'],
            'status' => ArticleStatus::Published,
            'published_at' => now()->subHours(3 + $index),
        ]);
    }
}
