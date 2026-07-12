<?php

use Illuminate\Support\Facades\Blade;

it('renders reusable public card components', function () {
    $agency = Blade::render(<<<'BLADE'
        <x-cards.agency
            name="GS AUTOBILAN Nkolbisson"
            address="Carrefour Onana"
            hours="07h00 – 18h00"
            phone="+237 678 844 791"
            book-href="/fr/rendez-vous"
        />
    BLADE);

    expect($agency)
        ->toContain('GS AUTOBILAN Nkolbisson')
        ->toContain('Carrefour Onana')
        ->toContain(__('actions.book'));

    $service = Blade::render(<<<'BLADE'
        <x-cards.service
            title="Véhicules légers"
            description="Contrôle technique pour voitures particulières."
            icon="truck"
            href="/fr/services"
        />
    BLADE);

    expect($service)
        ->toContain('Véhicules légers')
        ->toContain(__('actions.learn_more'));

    $article = Blade::render(<<<'BLADE'
        <x-cards.article
            title="Préparer son véhicule"
            excerpt="Les points à vérifier avant la visite."
            category="Conseils"
            date="11 juillet 2026"
            href="/fr/actualites/preparer-son-vehicule"
        />
    BLADE);

    expect($article)
        ->toContain('Préparer son véhicule')
        ->toContain('Conseils');

    $testimonial = Blade::render(<<<'BLADE'
        <x-cards.testimonial
            quote="Service rapide et professionnel."
            name="Client GS"
            role="Particulier"
        />
    BLADE);

    expect($testimonial)
        ->toContain('Service rapide et professionnel.')
        ->toContain('Client GS');
});

it('renders reusable public UI components', function () {
    $badge = Blade::render(<<<'BLADE'
        <x-ui.status-badge label="Confirmé" tone="success" />
    BLADE);

    expect($badge)->toContain('Confirmé');

    $faq = Blade::render(<<<'BLADE'
        <x-ui.faq-accordion :items="$items" />
    BLADE, [
        'items' => [
            [
                'question' => 'La réservation est-elle confirmée automatiquement ?',
                'answer' => 'Non, notre équipe confirme par téléphone ou WhatsApp.',
            ],
        ],
    ]);

    expect($faq)
        ->toContain('La réservation est-elle confirmée automatiquement ?')
        ->toContain('notre équipe confirme');

    $ctaGroup = Blade::render(<<<'BLADE'
        <x-ui.cta-group :actions="$actions" />
    BLADE, [
        'actions' => [
            [
                'label' => __('actions.book'),
                'href' => '/fr/rendez-vous',
                'icon' => 'calendar-days',
                'chevron' => true,
            ],
            [
                'label' => __('actions.track'),
                'href' => '/fr/suivi-rendez-vous',
                'icon' => 'document-text',
                'variant' => 'outline',
            ],
        ],
    ]);

    expect($ctaGroup)
        ->toContain(__('actions.book'))
        ->toContain(__('actions.track'));
});
