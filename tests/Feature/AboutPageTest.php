<?php

it('renders the about page hero in French', function () {
    $response = $this->get('/fr/a-propos');

    $response
        ->assertOk()
        ->assertSee('data-about-hero', false)
        ->assertSee('images/aboutpage/hero-about.png', false)
        ->assertSee('À propos de GS AUTOBILAN', false)
        ->assertSee("Votre sécurité,<br>c'est notre métier.", false)
        ->assertSee('GS AUTOBILAN accompagne les automobilistes', false)
        ->assertSee('2 agences<br>opérationnelles', false)
        ->assertSee('Ouvert<br>les jours fériés', false)
        ->assertSee('Service<br>professionnel', false)
        ->assertDontSee('Bilingue<br>FR / EN', false)
        ->assertSee('data-about-orientation', false)
        ->assertSee('Un centre de visite technique<br>orienté sécurité', false)
        ->assertSee('Notre mission', false)
        ->assertSee('Notre vision', false)
        ->assertSee('Nos valeurs', false)
        ->assertSee('Sécurité', false)
        ->assertSee('Professionnalisme', false)
        ->assertSee('data-about-inspection-team', false)
        ->assertSee('images/aboutpage/technician-about.png', false)
        ->assertSee('Des équipes engagées<br>pour un contrôle sérieux', false)
        ->assertSee('Vérification documentaire', false)
        ->assertSee('Contrôle des pneumatiques', false)
        ->assertSee('Orientation en cas de contre-visite', false)
        ->assertSee('data-about-locations', false)
        ->assertSee('Nos agences et notre direction', false)
        ->assertSee('GS AUTOBILAN<br>Nkolbisson', false)
        ->assertSee('GS AUTOBILAN<br>Obili Scalom', false)
        ->assertSee('Direction<br>Générale', false)
        ->assertSee('Itinéraire', false)
        ->assertSee('Prendre rendez-vous', false)
        ->assertSee('Contacter', false);

    preg_match('/<section[^>]*data-about-locations[^>]*>.*?<\/section>/s', $response->getContent(), $locationSection);

    expect($locationSection[0] ?? '')
        ->not->toContain('Appeler')
        ->not->toContain('href="tel:');
});

it('renders the about page hero in English', function () {
    $response = $this->get('/en/about');

    $response
        ->assertOk()
        ->assertSee('About GS AUTOBILAN', false)
        ->assertSee('Your safety<br>is our profession.', false)
        ->assertSee('GS AUTOBILAN supports motorists', false)
        ->assertSee('2 operational<br>agencies', false)
        ->assertSee('Open on<br>public holidays', false)
        ->assertSee('Professional<br>service', false)
        ->assertDontSee('Bilingual<br>FR / EN', false)
        ->assertSee('A technical inspection centre<br>focused on safety', false)
        ->assertSee('Our mission', false)
        ->assertSee('Our vision', false)
        ->assertSee('Our values', false)
        ->assertSee('Transparency', false)
        ->assertSee('Reliability', false)
        ->assertSee('Committed teams<br>for a serious inspection', false)
        ->assertSee('Document verification', false)
        ->assertSee('Tyre inspection', false)
        ->assertSee('Guidance in case of re-inspection', false)
        ->assertSee('Our agencies and head office', false)
        ->assertSee('GS AUTOBILAN<br>Nkolbisson', false)
        ->assertSee('Head<br>Office', false)
        ->assertSee('Directions', false)
        ->assertSee('Book an appointment', false)
        ->assertSee('Contact', false);

    preg_match('/<section[^>]*data-about-locations[^>]*>.*?<\/section>/s', $response->getContent(), $locationSection);

    expect($locationSection[0] ?? '')
        ->not->toContain('Call')
        ->not->toContain('href="tel:');
});
