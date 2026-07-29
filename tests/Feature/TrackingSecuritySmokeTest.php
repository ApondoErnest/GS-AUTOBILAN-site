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

it('keeps S081 failed tracking lookups generic and private', function (array $lookup, string $ip) {
    s081TrackingBooking();

    RateLimiter::clear('tracking-lookup|'.$ip);

    $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->followingRedirects()
        ->post('/fr/suivi-rendez-vous', $lookup)
        ->assertOk()
        ->assertSee('data-tracking-error', false)
        ->assertSee('Aucune demande ne correspond à ces trois informations.', false)
        ->assertDontSee('data-tracking-result', false)
        ->assertDontSee('Client S081 Confidential', false)
        ->assertDontSee('client-s081-private@example.test', false)
        ->assertDontSee('S081 internal scheduling note', false)
        ->assertDontSee('S081 private document note', false)
        ->assertDontSee('Votre rendez-vous S081 est confirme.', false)
        ->assertDontSee('Votre dossier S081 est pret.', false);
})->with([
    'wrong reference' => [[
        'reference' => 'GS-2026-081999',
        'phone' => '+237 699 081 000',
        'vehicle_registration' => 'CE081AB',
    ], '203.0.113.81'],
    'wrong phone' => [[
        'reference' => 'GS-2026-081001',
        'phone' => '+237 699 081 999',
        'vehicle_registration' => 'CE081AB',
    ], '203.0.113.82'],
    'wrong vehicle registration' => [[
        'reference' => 'GS-2026-081001',
        'phone' => '+237 699 081 000',
        'vehicle_registration' => 'CE081ZZ',
    ], '203.0.113.83'],
]);

it('triggers the S081 tracking lookup rate limit after five failed attempts', function () {
    s081TrackingBooking();

    $ip = '203.0.113.84';
    $key = 'tracking-lookup|'.$ip;
    $payload = [
        'reference' => 'GS-2026-081001',
        'phone' => '+237 699 081 000',
        'vehicle_registration' => 'CE081ZZ',
    ];

    RateLimiter::clear($key);

    foreach (range(1, 5) as $attempt) {
        $this->withServerVariables(['REMOTE_ADDR' => $ip])
            ->post('/fr/suivi-rendez-vous', $payload)
            ->assertRedirect('/fr/suivi-rendez-vous')
            ->assertSessionHasErrors('tracking_lookup');

        expect(RateLimiter::attempts($key))->toBe($attempt);
    }

    $limited = $this->withServerVariables(['REMOTE_ADDR' => $ip])
        ->post('/fr/suivi-rendez-vous', $payload);

    $limited
        ->assertRedirect('/fr/suivi-rendez-vous')
        ->assertHeader('X-RateLimit-Limit', '5')
        ->assertHeader('X-RateLimit-Remaining', '0')
        ->assertSessionHasErrors([
            'tracking_lookup' => 'Trop de tentatives de suivi. Réessayez dans 15 min.',
        ]);

    expect((int) $limited->headers->get('Retry-After'))
        ->toBeGreaterThan(0)
        ->toBeLessThanOrEqual(900);
    expect(RateLimiter::attempts($key))->toBe(5);
});

function s081TrackingBooking(): Booking
{
    $agency = Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN S081',
        'name_en' => 'GS AUTOBILAN S081',
        'slug' => 's081-agency',
        'address_fr' => 'Adresse S081',
        'address_en' => 'S081 address',
        'city' => 'Yaounde',
        'quarter' => 'S081',
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => 's081-agency@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $service = Service::query()->create([
        'title_fr' => 'Controle S081',
        'title_en' => 'S081 inspection',
        'slug_fr' => 'controle-s081',
        'slug_en' => 's081-inspection',
        'short_description_fr' => 'Controle technique S081.',
        'short_description_en' => 'S081 technical inspection.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    $booking = Booking::query()->create([
        'reference' => 'GS-2026-081001',
        'customer_name' => 'Client S081 Confidential',
        'phone' => '+237699081000',
        'whatsapp' => '+237699081001',
        'email' => 'client-s081-private@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE081AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-08-03',
        'preferred_time_slot' => 'Matin - 07h00-11h00',
        'confirmed_date' => '2026-08-04',
        'confirmed_time_slot' => '10h00-11h00',
        'status' => BookingStatus::Confirmed,
        'public_message' => 'Votre rendez-vous S081 est confirme.',
        'internal_notes' => 'S081 internal scheduling note',
    ]);

    DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::ReadyForVisit,
        'missing_information_note' => 'S081 private document note',
        'next_action_fr' => 'Action publique S081.',
        'next_action_en' => 'S081 public action.',
        'public_message_fr' => 'Votre dossier S081 est pret.',
        'public_message_en' => 'Your S081 file is ready.',
    ]);

    return $booking;
}
