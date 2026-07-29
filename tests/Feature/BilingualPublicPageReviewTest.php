<?php

it('renders completed public pages in each locale without half-translated review leaks', function () {
    $translationKeyPattern = '/(?<![\w-])(?:about|actions|agencies|booking|chrome|contact|footer|home|inspection|nav|news|services|tariffs|tracking|validation)\.[A-Za-z0-9_.-]+(?![\w-])/';

    foreach (s073ReviewedPublicPages() as $pageName => $localizedPages) {
        foreach (['fr', 'en'] as $locale) {
            $otherLocale = $locale === 'fr' ? 'en' : 'fr';
            $page = $localizedPages[$locale];
            $otherPage = $localizedPages[$otherLocale];
            $html = $this->get($page['uri'])
                ->assertOk()
                ->getContent();

            $this->assertStringContainsString(
                '<html lang="'.$locale.'"',
                $html,
                "{$pageName} did not render with the {$locale} document locale.",
            );
            $this->assertStringContainsString(
                $page['expected'],
                $html,
                "{$pageName} did not render its expected {$locale} review copy.",
            );
            $this->assertStringNotContainsString(
                $otherPage['expected'],
                $html,
                "{$pageName} leaked the {$otherLocale} review copy on the {$locale} page.",
            );
            $this->assertStringNotContainsString(
                'Placeholder for home modules.',
                $html,
                "{$pageName} rendered a placeholder shell.",
            );
            $this->assertDoesNotMatchRegularExpression(
                $translationKeyPattern,
                $html,
                "{$pageName} rendered an untranslated key on the {$locale} page.",
            );
        }
    }
});

/**
 * @return array<string, array{fr: array{uri: string, expected: string}, en: array{uri: string, expected: string}}>
 */
function s073ReviewedPublicPages(): array
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
                'expected' => 'Notre mission',
            ],
            'en' => [
                'uri' => '/en/about',
                'expected' => 'Our mission',
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
    ];
}
