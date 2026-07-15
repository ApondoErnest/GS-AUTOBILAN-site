<?php

it('renders the S056 homepage hero with the configured image carousel', function () {
    $response = $this->get('/fr/accueil');

    $response
        ->assertOk()
        ->assertSee('data-hero-carousel', false)
        ->assertSee('Bienvenue chez GS AUTOBILAN', false)
        ->assertSee('Centres professionnels de visite technique automobile', false)
        ->assertSee('2 agences', false)
        ->assertSee('Bilingue', false)
        ->assertSee('data-home-agencies', false)
        ->assertSee('Trouvez votre agence GS AUTOBILAN', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('Itinéraire', false)
        ->assertSee('Prendre RDV', false)
        ->assertSee('data-home-inspection', false)
        ->assertSee('Les points essentiels contrôlés', false)
        ->assertSee('Freinage', false)
        ->assertSee('Comment se déroule votre visite technique ?', false)
        ->assertSee('Contrôle Technique', false)
        ->assertSee('En savoir plus sur la visite technique', false)
        ->assertSee('data-home-tariffs-gallery', false)
        ->assertSee('Tarifs par catégorie', false)
        ->assertSee('Taxi / Auto-école', false)
        ->assertSee('17 900 FCFA', false)
        ->assertSee('Grand bus / Coaster', false)
        ->assertSee('19 080 FCFA', false)
        ->assertSee('Camions / Tracteurs / Sémi-remorques / Véhicules utilitaires lourds', false)
        ->assertSee('26 235 FCFA', false)
        ->assertSee('Autres engins', false)
        ->assertSee('41 750 FCFA', false)
        ->assertDontSee('45 500', false)
        ->assertDontSee('Ensemble articulé / Semi-remorque', false)
        ->assertSee('Pourquoi choisir', false)
        ->assertSee('Nos agences en images', false)
        ->assertDontSee('Voir la galerie complète', false)
        ->assertSee('data-home-advice-cta', false)
        ->assertSee('Conseils utiles avant votre visite', false)
        ->assertSee('Comment préparer votre véhicule pour la visite technique', false)
        ->assertSee('Documents nécessaires avant votre passage', false)
        ->assertSee('Que faire en cas de contre-visite ?', false)
        ->assertSee('Lire l&#039;article', false)
        ->assertSee('Voir tous les articles', false)
        ->assertSee('Votre véhicule est prêt pour la visite technique ?', false)
        ->assertSee('Vérifiez les feux, clignotants, phares et essuie-glaces.', false)
        ->assertSee('Carte grise originale du véhicule.', false)
        ->assertSee('Attestation d’assurance en cours de validité.', false)
        ->assertDontSee("Demandez votre rendez-vous dans l'agence GS AUTOBILAN la plus proche.", false)
        ->assertDontSee('FR</span>', false)
        ->assertDontSee('Essais Techniques', false)
        ->assertDontSee('Planifiez votre passage', false);

    foreach (range(1, 5) as $index) {
        $response->assertSee("images/homepage/hero-{$index}.png", false);
    }

    foreach (range(1, 2) as $index) {
        $response->assertSee("images/homepage/agency-{$index}.png", false);
    }

    foreach (range(3, 6) as $index) {
        $response->assertSee("images/homepage/agence-{$index}.png", false);
    }

    foreach (['prepare-visit', 'necessary-docs', 'case-cv'] as $image) {
        $response->assertSee("images/homepage/{$image}.png", false);
    }
});

it('renders the homepage hero with English copy on the English route', function () {
    $this->get('/en/home')
        ->assertOk()
        ->assertSee('Welcome to GS AUTOBILAN', false)
        ->assertSee('Professional vehicle technical inspection centres', false)
        ->assertSee('Find your GS AUTOBILAN agency', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('Book visit', false)
        ->assertSee('Key points inspected', false)
        ->assertSee('Technical Inspection', false)
        ->assertSee('Learn more about technical inspection', false)
        ->assertSee('Tariffs by category', false)
        ->assertSee('Taxi / Driving school', false)
        ->assertSee('Large bus / Coaster', false)
        ->assertSee('26 235 FCFA', false)
        ->assertSee('Other machinery', false)
        ->assertSee('41 750 FCFA', false)
        ->assertDontSee('Articulated unit / Semi-trailer', false)
        ->assertSee('Our agencies in pictures', false)
        ->assertDontSee('View complete gallery', false)
        ->assertSee('Useful tips before your visit', false)
        ->assertSee('How to prepare your vehicle for technical inspection', false)
        ->assertSee('Required documents before your visit', false)
        ->assertSee('What to do in case of re-inspection?', false)
        ->assertSee('Read article', false)
        ->assertSee('View all articles', false)
        ->assertSee('Is your vehicle ready for technical inspection?', false)
        ->assertSee('Check lights, indicators, headlights, and wipers.', false)
        ->assertSee('Original vehicle registration card.', false)
        ->assertSee('Valid insurance certificate.', false)
        ->assertDontSee('Request your appointment at the nearest GS AUTOBILAN agency.', false)
        ->assertSee('href="/en/booking"', false)
        ->assertSee('href="/en/appointment-tracking"', false)
        ->assertDontSee('Plan your visit', false);
});
