<?php

use App\Events\BookingCreated;
use App\Http\Middleware\ThrottlePublicFormSubmission;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('renders honeypot fields on booking tracking and contact forms', function () {
    config()->set('honeypot.randomize_name_field_name', false);

    foreach (['/fr/rendez-vous', '/fr/suivi-rendez-vous', '/fr/contact'] as $path) {
        $this->get($path)
            ->assertOk()
            ->assertSee('name="my_name"', false)
            ->assertSee('name="valid_from"', false);
    }
});

it('attaches spam protection and rate limits to the public form submit routes', function () {
    expect(Route::getRoutes()->getByName('fr.booking.store')?->gatherMiddleware())
        ->toContain('honeypot')
        ->toContain('public.form.throttle:booking');

    expect(Route::getRoutes()->getByName('fr.contact.store')?->gatherMiddleware())
        ->toContain('honeypot')
        ->toContain('public.form.throttle:contact');

    expect(Route::getRoutes()->getByName('fr.tracking.lookup')?->gatherMiddleware())
        ->toContain('honeypot')
        ->toContain('tracking.lookup.throttle');
});

it('blocks honeypot-filled public form submissions before records are created', function () {
    config()->set('honeypot.randomize_name_field_name', false);
    config()->set('honeypot.valid_from_timestamp', false);
    Event::fake([BookingCreated::class]);

    [$agency, $service] = s077BookingDependencies();
    $trackingBooking = s077TrackingBooking($agency, $service);

    $this->from('/fr/rendez-vous')
        ->post('/fr/rendez-vous', s077BookingPayload(['my_name' => 'bot-filled']))
        ->assertRedirect('/fr/rendez-vous')
        ->assertSessionHasErrors('public_form');

    expect(Booking::query()->where('reference', '!=', $trackingBooking->reference)->count())->toBe(0);
    Event::assertNotDispatched(BookingCreated::class);

    $this->postJson('/en/contact', [
        'my_name' => 'bot-filled',
        'name' => 'Spam Contact',
        'phone' => '+237677111222',
        'agency_slug' => $agency->slug,
        'subject' => 'Spam',
        'request_type' => 'Other request',
        'message' => 'This should not be stored.',
    ])
        ->assertUnprocessable()
        ->assertJsonPath('message', 'We could not validate this submission. Reload the page and try again.');

    $this->assertDatabaseCount('contact_messages', 0);

    $ip = '203.0.113.77';
    RateLimiter::clear('tracking-lookup|'.$ip);

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->from('/fr/suivi-rendez-vous')
        ->post('/fr/suivi-rendez-vous', [
            'my_name' => 'bot-filled',
            'reference' => $trackingBooking->reference,
            'phone' => $trackingBooking->phone,
            'vehicle_registration' => $trackingBooking->vehicle_registration,
        ])
        ->assertRedirect('/fr/suivi-rendez-vous')
        ->assertSessionHasErrors('public_form');

    expect(RateLimiter::attempts('tracking-lookup|'.$ip))->toBe(0);
});

it('rate limits repeated booking and contact form submissions by requester', function () {
    $bookingIp = '203.0.113.78';
    $bookingKey = ThrottlePublicFormSubmission::limiterKey('booking', $bookingIp);
    RateLimiter::clear($bookingKey);

    foreach (range(1, ThrottlePublicFormSubmission::MAX_ATTEMPTS) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $bookingIp])
            ->from('/fr/rendez-vous')
            ->post('/fr/rendez-vous', [])
            ->assertRedirect('/fr/rendez-vous')
            ->assertSessionHasErrors();
    }

    $this->withServerVariables(['REMOTE_ADDR' => $bookingIp])
        ->followingRedirects()
        ->from('/fr/rendez-vous')
        ->post('/fr/rendez-vous', [])
        ->assertOk()
        ->assertSee('Trop de soumissions. Réessayez dans 15 min.', false);

    $contactIp = '203.0.113.79';
    $contactKey = ThrottlePublicFormSubmission::limiterKey('contact', $contactIp);
    RateLimiter::clear($contactKey);

    foreach (range(1, ThrottlePublicFormSubmission::MAX_ATTEMPTS) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $contactIp])
            ->postJson('/en/contact', [])
            ->assertUnprocessable();
    }

    $this->withServerVariables(['REMOTE_ADDR' => $contactIp])
        ->postJson('/en/contact', [])
        ->assertTooManyRequests()
        ->assertJsonPath('message', 'Too many submissions. Try again in 15 min.');
});

/**
 * @return array{Agency, Service}
 */
function s077BookingDependencies(): array
{
    $agency = Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
        'slug' => 'nkolbisson',
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
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $service = Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    return [$agency, $service];
}

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function s077BookingPayload(array $overrides = []): array
{
    return array_merge([
        'agency' => 'nkolbisson',
        'service_type' => 'periodic',
        'vehicle_category' => 'light',
        'vehicle_registration' => 'CE123AB',
        'vehicle_brand' => 'Toyota',
        'vehicle_model' => 'Corolla',
        'vehicle_year' => '2020',
        'preferred_date' => now()->addDay()->toDateString(),
        'preferred_time_slot' => 'Matin — 07h00 à 11h00',
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'email' => 'client@example.test',
        'contact_mode' => 'WhatsApp',
        'confirmation_understood' => '1',
    ], $overrides);
}

function s077TrackingBooking(Agency $agency, Service $service): Booking
{
    return Booking::query()->create([
        'reference' => 'GS-2026-077001',
        'customer_name' => 'Client Tracking',
        'phone' => '+237699077000',
        'email' => 'client-tracking@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE077AB',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-31',
        'preferred_time_slot' => '09h30-10h30',
        'status' => 'confirmed',
    ]);
}
