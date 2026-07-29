<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps S083 completed public pages bilingual and responsive-ready', function (string $pageName, array $localizedPages) {
    $translationKeyPattern = '/(?<![\w-])(?:about|actions|agencies|booking|chrome|contact|footer|home|inspection|nav|news|services|tariffs|tracking|validation)\.[A-Za-z0-9_.-]+(?![\w-])/';

    foreach (['fr', 'en'] as $locale) {
        $page = $localizedPages[$locale];
        $otherLocale = $locale === 'fr' ? 'en' : 'fr';
        $otherPage = $localizedPages[$otherLocale];
        $html = $this->get($page['uri'])
            ->assertOk()
            ->getContent();

        expect($html)
            ->toContain('<html lang="'.$locale.'"')
            ->toContain('<meta name="viewport" content="width=device-width, initial-scale=1">')
            ->toContain('id="gs-mobile-menu"')
            ->toContain('data-mobile-menu-open')
            ->toContain('data-mobile-menu-close')
            ->toContain($page['expected'])
            ->toContain('href="'.$page['uri'].'"')
            ->toContain('href="'.$otherPage['uri'].'"')
            ->not->toContain('Placeholder for home modules.');

        expect(strip_tags($html))
            ->not->toMatch($translationKeyPattern, "{$pageName} rendered an untranslated key on the {$locale} page.");
    }
})->with(s083CompletedPublicPageDataset());

/**
 * @return array<string, array{0: string, 1: array{fr: array{uri: string, expected: string}, en: array{uri: string, expected: string}}}>
 */
function s083CompletedPublicPageDataset(): array
{
    return collect(s083CompletedPublicPages())
        ->mapWithKeys(fn (array $localizedPages, string $pageName): array => [
            $pageName => [$pageName, $localizedPages],
        ])
        ->all();
}

/**
 * @return array<string, array{fr: array{uri: string, expected: string}, en: array{uri: string, expected: string}}>
 */
function s083CompletedPublicPages(): array
{
    return [
        'home' => [
            'fr' => [
                'uri' => '/fr/accueil',
                'expected' => 'Centres professionnels de visite technique automobile à Yaoundé',
            ],
            'en' => [
                'uri' => '/en/home',
                'expected' => 'Professional vehicle technical inspection centres in Yaounde',
            ],
        ],
        'about' => [
            'fr' => [
                'uri' => '/fr/a-propos',
                'expected' => 'À propos de GS AUTOBILAN',
            ],
            'en' => [
                'uri' => '/en/about',
                'expected' => 'About GS AUTOBILAN',
            ],
        ],
        'agencies' => [
            'fr' => [
                'uri' => '/fr/nos-agences',
                'expected' => 'Trouvez votre agence',
            ],
            'en' => [
                'uri' => '/en/our-agencies',
                'expected' => 'Find your',
            ],
        ],
        'services' => [
            'fr' => [
                'uri' => '/fr/services',
                'expected' => 'Des services de visite technique pensés pour la sécurité',
            ],
            'en' => [
                'uri' => '/en/services',
                'expected' => 'Technical inspection services designed for safety',
            ],
        ],
        'tariffs' => [
            'fr' => [
                'uri' => '/fr/tarifs',
                'expected' => 'Des tarifs clairs pour chaque catégorie de véhicule',
            ],
            'en' => [
                'uri' => '/en/tariffs',
                'expected' => 'Clear tariffs for every vehicle category',
            ],
        ],
        'technical_inspection' => [
            'fr' => [
                'uri' => '/fr/visite-technique',
                'expected' => 'Comprendre et réussir votre visite technique',
            ],
            'en' => [
                'uri' => '/en/technical-inspection',
                'expected' => 'Understand and complete your technical inspection',
            ],
        ],
        'booking' => [
            'fr' => [
                'uri' => '/fr/rendez-vous',
                'expected' => 'Demandez votre créneau de visite technique',
            ],
            'en' => [
                'uri' => '/en/booking',
                'expected' => 'Request your technical inspection visit slot',
            ],
        ],
        'tracking' => [
            'fr' => [
                'uri' => '/fr/suivi-rendez-vous',
                'expected' => 'Suivez votre demande de rendez-vous',
            ],
            'en' => [
                'uri' => '/en/appointment-tracking',
                'expected' => 'Track your appointment request',
            ],
        ],
        'contact' => [
            'fr' => [
                'uri' => '/fr/contact',
                'expected' => 'Que souhaitez-vous faire ?',
            ],
            'en' => [
                'uri' => '/en/contact',
                'expected' => 'What would you like to do?',
            ],
        ],
        'news' => [
            'fr' => [
                'uri' => '/fr/actualites',
                'expected' => 'Préparez votre visite technique avec les bons repères',
            ],
            'en' => [
                'uri' => '/en/news',
                'expected' => 'Prepare your technical inspection with the right guidance',
            ],
        ],
    ];
}
