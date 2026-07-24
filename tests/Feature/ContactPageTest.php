<?php

use App\Models\Agency;
use App\Models\ContactMessage;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

it('renders the contact intro section in French', function () {
    $response = $this->get('/fr/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-intro', false)
        ->assertSee('Que souhaitez-vous faire ?', false)
        ->assertSee('Choisissez votre besoin pour être orienté rapidement.', false)
        ->assertSee('images/contacts/contact-calendar.svg', false)
        ->assertSee('images/contacts/contact-phone.svg', false)
        ->assertSee('images/contacts/contact-map.svg', false)
        ->assertSee('images/contacts/contact-question.svg', false)
        ->assertSee('Je veux prendre<br>rendez-vous', false)
        ->assertSee('Je veux appeler<br>une agence', false)
        ->assertSee("Je veux trouver<br>l’itinéraire", false)
        ->assertSee("J’ai une question<br>ou un problème", false)
        ->assertSee('href="/fr/rendez-vous"', false)
        ->assertSee('href="#contact-agencies"', false)
        ->assertSee('href="/fr/nos-agences"', false)
        ->assertSee('href="#contact-form"', false);
});

it('renders the contact agencies section in French with embedded maps', function () {
    $response = $this->get('/fr/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-agencies', false)
        ->assertSee('Nos agences de visite technique', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('Ouvert actuellement', false)
        ->assertSee('nkolbisson@gsautobilan.cm', false)
        ->assertSee('obili@gsautobilan.cm', false)
        ->assertSee('maps.google.com/maps?hl=fr', false)
        ->assertSee('3.8882487,11.4549352', false)
        ->assertSee('3.8471748,11.4967492', false)
        ->assertSee('WhatsApp', false)
        ->assertSee('Prendre rendez-vous', false);

    preg_match('/<section[^>]*data-contact-agencies[^>]*>.*?<\/section>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->toContain('<iframe')
        ->not->toContain('Ouvrir dans Google Maps')
        ->not->toContain('href="tel:')
        ->not->toContain('www.google.com/maps');
});

it('renders the contact message desk and head office card in French', function () {
    $response = $this->get('/fr/contact?agence=obili-scalom');

    $response
        ->assertOk()
        ->assertSee('data-contact-desk', false)
        ->assertSee('data-contact-message-form', false)
        ->assertSee('data-contact-head-office', false)
        ->assertSee('Envoyer un message', false)
        ->assertSee('Nom complet', false)
        ->assertSee('Téléphone / WhatsApp', false)
        ->assertSee('Email (optionnel)', false)
        ->assertSee('Sujet', false)
        ->assertSee('Agence concernée', false)
        ->assertSee('Type de demande', false)
        ->assertSee('Message', false)
        ->assertSee('<option value="obili-scalom" selected>GS AUTOBILAN Obili Scalom</option>', false)
        ->assertSee('Direction Générale — Bastos', false)
        ->assertSee('Pour les questions administratives, partenariats et demandes corporate.', false)
        ->assertSee('Appeler la direction', false)
        ->assertSee('Envoyer un email', false)
        ->assertSee('Pas de ligne de visite technique sur ce site', false);

    preg_match('/<aside[^>]*data-contact-head-office[^>]*>.*?<\/aside>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->not->toContain('Prendre rendez-vous')
        ->not->toContain('WhatsApp');
});

it('renders the contact FAQ section in French', function () {
    $response = $this->get('/fr/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-faq', false)
        ->assertSee('Questions fréquentes', false)
        ->assertSee('Quels documents dois-je apporter ?', false)
        ->assertSee("Comment se passe la confirmation d’un rendez-vous ?", false)
        ->assertSee('Êtes-vous ouverts les jours fériés ?', false)
        ->assertSee('Quelle agence choisir ?', false)
        ->assertSee('Comment suivre ma demande ?', false)
        ->assertSee('Que faire en cas de contre-visite ?', false)
        ->assertSee('Où se trouve la Direction Générale ?', false)
        ->assertSee('Puis-je venir sans rendez-vous ?', false)
        ->assertDontSee('data-contact-assistance-gate', false)
        ->assertDontSee('Besoin d’une réponse rapide ?', false)
        ->assertDontSee('Appeler Nkolbisson', false)
        ->assertDontSee('Appeler Obili Scalom', false);

    preg_match('/<section[^>]*data-contact-faq[^>]*>.*?<\/section>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->toContain('xl:px-32')
        ->not->toContain('data-contact-assistance-gate');
    expect(substr_count($matches[0] ?? '', '<details'))->toBe(8);
});

it('renders the contact intro section in English', function () {
    $response = $this->get('/en/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-intro', false)
        ->assertSee('What would you like to do?', false)
        ->assertSee('Choose your need so we can guide you quickly.', false)
        ->assertSee('images/contacts/contact-calendar.svg', false)
        ->assertSee('I want to book<br>an appointment', false)
        ->assertSee('I want to call<br>an agency', false)
        ->assertSee('I want to find<br>directions', false)
        ->assertSee('I have a question<br>or a problem', false)
        ->assertSee('href="/en/booking"', false)
        ->assertSee('href="#contact-agencies"', false)
        ->assertSee('href="/en/our-agencies"', false)
        ->assertSee('href="#contact-form"', false);
});

it('renders the contact agencies section in English with embedded maps', function () {
    $response = $this->get('/en/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-agencies', false)
        ->assertSee('Our technical inspection agencies', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('Open now', false)
        ->assertSee('nkolbisson@gsautobilan.cm', false)
        ->assertSee('obili@gsautobilan.cm', false)
        ->assertSee('maps.google.com/maps?hl=en', false)
        ->assertSee('3.8882487,11.4549352', false)
        ->assertSee('3.8471748,11.4967492', false)
        ->assertSee('WhatsApp', false)
        ->assertSee('Book an appointment', false);

    preg_match('/<section[^>]*data-contact-agencies[^>]*>.*?<\/section>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->toContain('<iframe')
        ->not->toContain('Open in Google Maps')
        ->not->toContain('Open larger map')
        ->not->toContain('href="tel:')
        ->not->toContain('www.google.com/maps');
});

it('renders the contact message desk and head office card in English', function () {
    $response = $this->get('/en/contact?agence=nkolbisson');

    $response
        ->assertOk()
        ->assertSee('data-contact-desk', false)
        ->assertSee('data-contact-message-form', false)
        ->assertSee('data-contact-head-office', false)
        ->assertSee('Send a message', false)
        ->assertSee('Full name', false)
        ->assertSee('Phone / WhatsApp', false)
        ->assertSee('Email (optional)', false)
        ->assertSee('Subject', false)
        ->assertSee('Agency concerned', false)
        ->assertSee('Request type', false)
        ->assertSee('<option value="nkolbisson" selected>GS AUTOBILAN Nkolbisson</option>', false)
        ->assertSee('Head Office — Bastos', false)
        ->assertSee('For administrative questions, partnerships and corporate requests.', false)
        ->assertSee('Call head office', false)
        ->assertSee('Send an email', false)
        ->assertSee('No technical inspection lane at this site', false);

    preg_match('/<aside[^>]*data-contact-head-office[^>]*>.*?<\/aside>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->not->toContain('Book an appointment')
        ->not->toContain('WhatsApp');
});

it('renders the contact FAQ section in English', function () {
    $response = $this->get('/en/contact');

    $response
        ->assertOk()
        ->assertSee('data-contact-faq', false)
        ->assertSee('Frequently asked questions', false)
        ->assertSee('Which documents should I bring?', false)
        ->assertSee('How is an appointment confirmed?', false)
        ->assertSee('Are you open on public holidays?', false)
        ->assertSee('Which agency should I choose?', false)
        ->assertSee('How can I track my request?', false)
        ->assertSee('What should I do for a counter-visit?', false)
        ->assertSee('Where is the Head Office?', false)
        ->assertSee('Can I come without an appointment?', false)
        ->assertDontSee('data-contact-assistance-gate', false)
        ->assertDontSee('Need a quick answer?', false)
        ->assertDontSee('Call Nkolbisson', false)
        ->assertDontSee('Call Obili Scalom', false);

    preg_match('/<section[^>]*data-contact-faq[^>]*>.*?<\/section>/s', $response->getContent(), $matches);

    expect($matches[0] ?? '')
        ->toContain('xl:px-32')
        ->not->toContain('data-contact-assistance-gate');
    expect(substr_count($matches[0] ?? '', '<details'))->toBe(8);
});

it('stores contact desk submissions with an agency slug', function () {
    Notification::fake();
    $this->withoutMiddleware([
        ValidateCsrfToken::class,
        VerifyCsrfToken::class,
    ]);

    $agency = contactPageAgency('nkolbisson');

    $this->from('/fr/contact?agence=nkolbisson')->post('/fr/contact', [
        'name' => ' Client Contact ',
        'phone' => ' +237 677 000 000 ',
        'email' => '',
        'agency_slug' => 'nkolbisson',
        'subject' => ' Renseignement ',
        'request_type' => 'Question administrative',
        'message' => ' Je voudrais des informations. ',
    ])->assertRedirect('/fr/contact?agence=nkolbisson')
        ->assertSessionHas('contact_message_status', 'Votre message a bien été envoyé. Notre équipe vous répondra rapidement.');

    $message = ContactMessage::query()->firstOrFail();

    expect($message)
        ->name->toBe('Client Contact')
        ->phone->toBe('+237677000000')
        ->email->toBeNull()
        ->agency_id->toBe($agency->id)
        ->subject->toBe('Question administrative — Renseignement')
        ->message->toBe('Je voudrais des informations.');
});

function contactPageAgency(string $slug): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.ucfirst($slug),
        'name_en' => 'GS AUTOBILAN '.ucfirst($slug),
        'slug' => $slug,
        'address_fr' => 'Carrefour Onana',
        'address_en' => 'Onana junction',
        'city' => 'Yaounde',
        'quarter' => 'Nkolbisson',
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => 'nkolbisson@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'sort_order' => 1,
        'is_active' => true,
    ]);
}
