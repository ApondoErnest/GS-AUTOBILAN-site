<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\RateLimiter;

uses(RefreshDatabase::class);

it('renders the tracking hero in French', function () {
    $this->get('/fr/suivi-rendez-vous')
        ->assertOk()
        ->assertSee('data-tracking-hero', false)
        ->assertSee('Suivi de demande', false)
        ->assertSee('Suivez votre demande de rendez-vous', false)
        ->assertSee('Consultez la confirmation de votre rendez-vous et l’état de préparation de votre dossier.', false)
        ->assertSee('data-tracking-hero-notice', false)
        ->assertSee('Ce service ne suit pas votre véhicule en temps réel sur la ligne de contrôle.', false)
        ->assertSee('Il présente uniquement le statut de votre demande de rendez-vous et la préparation de votre dossier.', false)
        ->assertSee('data-tracking-lookup', false)
        ->assertSee('Retrouvez votre demande', false)
        ->assertSee('Saisissez les informations utilisées lors de votre demande de rendez-vous.', false)
        ->assertSee('Référence de demande', false)
        ->assertSee('Téléphone ou numéro WhatsApp', false)
        ->assertSee('Immatriculation du véhicule', false)
        ->assertSee('Suivre ma demande', false)
        ->assertSee('Vous n’avez plus votre référence ?', false)
        ->assertSee('Nous vous aidons à la retrouver', false)
        ->assertDontSee('data-tracking-result', false);
});

it('renders the tracking hero in English', function () {
    $this->get('/en/appointment-tracking')
        ->assertOk()
        ->assertSee('data-tracking-hero', false)
        ->assertSee('Request tracking', false)
        ->assertSee('Track your appointment request', false)
        ->assertSee('Check your appointment confirmation and document preparation status.', false)
        ->assertSee('data-tracking-hero-notice', false)
        ->assertSee('This service does not track your vehicle in real time on the inspection lane.', false)
        ->assertSee('It only shows your appointment request status and document preparation progress.', false)
        ->assertSee('data-tracking-lookup', false)
        ->assertSee('Find your request', false)
        ->assertSee('Enter the information used when making your appointment request.', false)
        ->assertSee('Request reference', false)
        ->assertSee('Phone or WhatsApp number', false)
        ->assertSee('Vehicle registration', false)
        ->assertSee('Track my request', false)
        ->assertSee('No longer have your reference?', false)
        ->assertSee('We can help you find it', false)
        ->assertDontSee('data-tracking-result', false);
});

it('prefills tracking credentials from a booking confirmation link', function () {
    $this->get('/fr/suivi-rendez-vous?reference=GS-2026-000001&phone=%2B237699000000&vehicle_registration=CE123AB')
        ->assertOk()
        ->assertSee('name="reference" value="GS-2026-000001"', false)
        ->assertSee('name="phone" value="+237699000000"', false)
        ->assertSee('name="vehicle_registration" value="CE123AB"', false);
});

it('shows a compact generic error when tracking lookup validation fails', function () {
    $this->followingRedirects()
        ->post('/fr/suivi-rendez-vous', [
            'reference' => '',
            'phone' => '',
            'vehicle_registration' => '',
        ])
        ->assertOk()
        ->assertSee('data-tracking-error', false)
        ->assertSee('Veuillez vérifier les trois informations de suivi puis réessayer.', false)
        ->assertDontSee('data-tracking-result', false);
});

it('shows a compact generic error when no tracking record matches', function () {
    $this->followingRedirects()
        ->post('/fr/suivi-rendez-vous', [
            'reference' => 'GS-2026-999999',
            'phone' => '+237699999999',
            'vehicle_registration' => 'CE999AB',
        ])
        ->assertOk()
        ->assertSee('data-tracking-error', false)
        ->assertSee('Aucune demande ne correspond à ces trois informations.', false)
        ->assertDontSee('data-tracking-result', false);
});

it('rate limits repeated failed tracking lookups by requester', function () {
    $ip = '203.0.113.70';

    RateLimiter::clear('tracking-lookup|'.$ip);

    foreach (range(1, 5) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->post('/fr/suivi-rendez-vous', [
                'reference' => 'GS-2026-999999',
                'phone' => '+237699999999',
                'vehicle_registration' => 'CE999AB',
            ])
            ->assertRedirect('/fr/suivi-rendez-vous')
            ->assertSessionHasErrors('tracking_lookup');
    }

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->followingRedirects()
        ->post('/fr/suivi-rendez-vous', [
            'reference' => 'GS-2026-999999',
            'phone' => '+237699999999',
            'vehicle_registration' => 'CE999AB',
        ])
        ->assertOk()
        ->assertSee('data-tracking-error', false)
        ->assertSee('Trop de tentatives de suivi. Réessayez dans 15 min.', false)
        ->assertDontSee('data-tracking-result', false);
});

it('clears failed tracking lookup attempts after a successful match', function () {
    s069TrackingBooking();

    $ip = '203.0.113.71';

    RateLimiter::clear('tracking-lookup|'.$ip);

    foreach (range(1, 4) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->post('/fr/suivi-rendez-vous', [
                'reference' => 'GS-2026-999999',
                'phone' => '+237699999999',
                'vehicle_registration' => 'CE999AB',
            ])
            ->assertRedirect('/fr/suivi-rendez-vous')
            ->assertSessionHasErrors('tracking_lookup');
    }

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->post('/fr/suivi-rendez-vous', [
            'reference' => 'GS-2026-069001',
            'phone' => '+237699069000',
            'vehicle_registration' => 'CE069AB',
        ])
        ->assertOk()
        ->assertSee('data-tracking-result', false);

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->post('/fr/suivi-rendez-vous', [
            'reference' => 'GS-2026-999999',
            'phone' => '+237699999999',
            'vehicle_registration' => 'CE999AB',
        ])
        ->assertRedirect('/fr/suivi-rendez-vous')
        ->assertSessionHasErrors('tracking_lookup');
});

it('shows the public tracking result when all three credentials match', function () {
    s069TrackingBooking();

    $this->post('/fr/suivi-rendez-vous', [
        'reference' => ' gs-2026-069001 ',
        'phone' => '+237 699 069 000',
        'vehicle_registration' => ' ce 069 ab ',
    ])
        ->assertOk()
        ->assertSee('data-tracking-result', false)
        ->assertSee('GS-2026-069001', false)
        ->assertSee('GS AUTOBILAN Obili Scalom', false)
        ->assertSee('31/07/2026', false)
        ->assertSee('09h30-10h30', false)
        ->assertSee('Confirmé', false)
        ->assertSee('Prêt pour le passage', false)
        ->assertSee('Présentez-vous avec les originaux.', false)
        ->assertSee('Votre rendez-vous est confirmé.', false)
        ->assertSee('Votre dossier est prêt.', false)
        ->assertSee('href="/fr/rendez-vous/GS-2026-069001/recapitulatif.pdf"', false)
        ->assertDontSee('Client Tracking', false)
        ->assertDontSee('client-tracking@example.test', false)
        ->assertDontSee('Internal tracking note', false)
        ->assertDontSee('Private document note', false);
});

function s069TrackingBooking(): Booking
{
    $agency = Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Obili Scalom',
        'name_en' => 'GS AUTOBILAN Obili Scalom',
        'slug' => 'obili-scalom',
        'address_fr' => 'Obili Scalom',
        'address_en' => 'Obili Scalom',
        'city' => 'Yaounde',
        'quarter' => 'Obili',
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => 'obili@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-19h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-19:00'],
        'latitude' => 3.862,
        'longitude' => 11.495,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $service = Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique.',
        'short_description_en' => 'Technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $booking = Booking::query()->create([
        'reference' => 'GS-2026-069001',
        'customer_name' => 'Client Tracking',
        'phone' => '+237699069000',
        'whatsapp' => '+237699069001',
        'email' => 'client-tracking@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE069AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-30',
        'preferred_time_slot' => 'Matin - 07h00-11h00',
        'confirmed_date' => '2026-07-31',
        'confirmed_time_slot' => '09h30-10h30',
        'status' => BookingStatus::Confirmed,
        'public_message' => 'Votre rendez-vous est confirmé.',
        'internal_notes' => 'Internal tracking note',
    ]);

    DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::ReadyForVisit,
        'missing_information_note' => 'Private document note',
        'next_action_fr' => 'Présentez-vous avec les originaux.',
        'next_action_en' => 'Please come with the originals.',
        'public_message_fr' => 'Votre dossier est prêt.',
        'public_message_en' => 'Your file is ready.',
    ]);

    return $booking;
}
