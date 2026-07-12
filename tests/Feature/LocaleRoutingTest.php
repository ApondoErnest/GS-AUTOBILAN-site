<?php

it('redirects the root path to the default French home page', function () {
    $this->get('/')->assertRedirect('/fr/accueil');
});

it('renders the French home page with French locale links', function () {
    $this->get('/fr/accueil')
        ->assertOk()
        ->assertSee('Votre sécurité', false)
        ->assertSee('href="/fr/rendez-vous"', false)
        ->assertSee('href="/fr/suivi-rendez-vous"', false)
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

it('registers the localized public route skeletons', function () {
    $this->get('/fr/contact')->assertOk()->assertSee('Contact', false);
    $this->get('/en/contact')->assertOk()->assertSee('Contact', false);
    $this->get('/fr/actualites/preparer-sa-visite')->assertOk();
    $this->get('/en/news/prepare-your-visit')->assertOk();
});

it('does not match unsupported locale prefixes', function () {
    $this->get('/de/home')->assertNotFound();
});
