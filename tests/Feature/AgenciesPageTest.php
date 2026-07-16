<?php

it('renders the agencies page hero in French', function () {
    $response = $this->get('/fr/nos-agences');

    $response
        ->assertOk()
        ->assertSee('data-agencies-hero', false)
        ->assertSee('images/agencies/hero-agencies.png', false)
        ->assertSee('Nos agences', false)
        ->assertSee('Trouvez votre agence<br>GS AUTOBILAN', false)
        ->assertSee('Deux centres opérationnels à Yaoundé', false)
        ->assertSee('2 agences<br>opérationnelles', false)
        ->assertSee('Ouvert les<br>jours fériés', false)
        ->assertSee('Service<br>professionnel', false)
        ->assertSee('Confirmation<br>par WhatsApp', false)
        ->assertSee('href="#agence-nkolbisson"', false)
        ->assertSee('Aller à Nkolbisson', false)
        ->assertSee('href="#agence-obili-scalom"', false)
        ->assertSee('Aller à Obili Scalom', false)
        ->assertSee('href="/fr/rendez-vous"', false)
        ->assertSee('data-agencies-list', false)
        ->assertSee('id="agence-nkolbisson"', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('Carrefour Onana, à côté de la station Ajaxx', false)
        ->assertSee('Lundi à Samedi : 07h00 – 18h00', false)
        ->assertSee('href="https://wa.me/237678844791"', false)
        ->assertSee('data-agency-map', false)
        ->assertSee('data-agency-map-frame', false)
        ->assertSee('data-agency-map-zoom-in', false)
        ->assertSee('data-agency-map-zoom-out', false)
        ->assertSee('https://maps.google.com/maps?hl=fr', false)
        ->assertSee('Agrandir le plan', false)
        ->assertSee('3.8882487,11.4549352', false)
        ->assertSee('id="agence-obili-scalom"', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('Dimanche : 07h00 – 15h00', false)
        ->assertSee('3.8471748,11.4967492', false)
        ->assertSee('Prendre RDV', false);

    preg_match('/<section[^>]*data-agencies-list[^>]*>.*?<\/section>/s', $response->getContent(), $agencySection);

    expect($agencySection[0] ?? '')
        ->not->toContain('Itinéraire GPS')
        ->not->toContain('href="tel:')
        ->not->toContain('Appeler');
});

it('renders the agencies page hero in English', function () {
    $response = $this->get('/en/our-agencies');

    $response
        ->assertOk()
        ->assertSee('data-agencies-hero', false)
        ->assertSee('Our agencies', false)
        ->assertSee('Find your<br>GS AUTOBILAN agency', false)
        ->assertSee('Two operational centres in Yaounde', false)
        ->assertSee('2 operational<br>agencies', false)
        ->assertSee('Open on<br>public holidays', false)
        ->assertSee('Professional<br>service', false)
        ->assertSee('Confirmation<br>by WhatsApp', false)
        ->assertSee('Go to Nkolbisson', false)
        ->assertSee('Go to Obili Scalom', false)
        ->assertSee('href="/en/booking"', false)
        ->assertSee('data-agencies-list', false)
        ->assertSee('id="agency-nkolbisson"', false)
        ->assertSee('Carrefour Onana, next to Ajaxx station', false)
        ->assertSee('Monday to Saturday: 07:00 – 18:00', false)
        ->assertSee('WhatsApp', false)
        ->assertSee('Book', false)
        ->assertSee('Open larger map', false)
        ->assertSee('data-agency-map-zoom-in', false)
        ->assertSee('data-agency-map-zoom-out', false)
        ->assertSee('https://maps.google.com/maps?hl=en', false)
        ->assertSee('id="agency-obili-scalom"', false)
        ->assertSee('Sunday: 07:00 – 15:00', false);

    preg_match('/<section[^>]*data-agencies-list[^>]*>.*?<\/section>/s', $response->getContent(), $agencySection);

    expect($agencySection[0] ?? '')
        ->not->toContain('GPS directions')
        ->not->toContain('href="tel:')
        ->not->toContain('Call');
});
