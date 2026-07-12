<?php

use App\Data\TrackingResult;
use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Services\TrackingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns a safe public tracking result when all credentials match', function () {
    $booking = s043TrackingBooking();

    $result = app(TrackingService::class)->lookup(
        reference: ' gs-2026-000001 ',
        phone: '+237 699 000 000',
        vehicleRegistration: 'ce 123 ab',
    );

    expect($result)->toBeInstanceOf(TrackingResult::class);
    expect($result->bookingStatus)->toBe(BookingStatus::Confirmed);
    expect($result->documentReadinessStatus)->toBe(DocumentReadinessStatus::ReadyForVisit);

    $payload = $result->toArray();

    expect($payload['reference'])->toBe('GS-2026-000001');
    expect($payload['agency']['slug'])->toBe('nkolbisson');
    expect($payload['agency']['name'])->toBe([
        'fr' => 'GS AUTOBILAN Nkolbisson',
        'en' => 'GS AUTOBILAN Nkolbisson',
    ]);
    expect($payload['agency']['phones'])->toBe(['+237678844791']);
    expect($payload['agency']['whatsapp'])->toBe('+237678844791');
    expect($payload['requested'])->toBe([
        'date' => '2026-07-20',
        'time_slot' => '09h00-10h00',
    ]);
    expect($payload['confirmed'])->toBe([
        'date' => '2026-07-21',
        'time_slot' => '10h00-11h00',
    ]);
    expect($payload['booking_status'])->toBe('confirmed');
    expect($payload['document_status'])->toBe('ready_for_visit');
    expect($payload['next_action'])->toBe([
        'fr' => 'Presentez-vous avec vos documents originaux.',
        'en' => 'Please come with your original documents.',
    ]);
    expect($payload['public_message'])->toBe([
        'booking' => 'Votre rendez-vous est confirme.',
        'document' => [
            'fr' => 'Vos documents semblent prets.',
            'en' => 'Your documents appear ready.',
        ],
    ]);

    $encodedPayload = json_encode($payload);

    expect($encodedPayload)->not->toContain($booking->customer_name);
    expect($encodedPayload)->not->toContain($booking->phone);
    expect($encodedPayload)->not->toContain($booking->email);
    expect($encodedPayload)->not->toContain('Internal scheduling note');
    expect($encodedPayload)->not->toContain('Private missing information note');
});

it('returns null unless reference, phone, and vehicle registration all match', function () {
    s043TrackingBooking();

    $tracking = app(TrackingService::class);

    expect($tracking->lookup('GS-2026-000999', '+237699000000', 'CE123AB'))->toBeNull();
    expect($tracking->lookup('GS-2026-000001', '+237699000001', 'CE123AB'))->toBeNull();
    expect($tracking->lookup('GS-2026-000001', '+237699000000', 'CE123AC'))->toBeNull();
    expect($tracking->lookup('', '+237699000000', 'CE123AB'))->toBeNull();
    expect($tracking->lookup('GS-2026-000001', '', 'CE123AB'))->toBeNull();
    expect($tracking->lookup('GS-2026-000001', '+237699000000', ''))->toBeNull();
});

it('defaults missing document readiness to not reviewed in the public result', function () {
    $booking = s043TrackingBooking(createDocumentReadiness: false);

    $result = app(TrackingService::class)->lookup(
        reference: $booking->reference,
        phone: $booking->phone,
        vehicleRegistration: $booking->vehicle_registration,
    );

    expect($result)->toBeInstanceOf(TrackingResult::class);
    expect($result->documentReadinessStatus)->toBe(DocumentReadinessStatus::NotReviewed);
    expect($result->toArray()['document_status'])->toBe('not_reviewed');
});

function s043TrackingBooking(bool $createDocumentReadiness = true): Booking
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
        'map_link' => 'https://www.google.com/maps?q=3.8882487,11.4549352',
        'status' => 'operational',
        'sort_order' => 1,
    ]);

    $inspectionService = Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
    ]);

    $booking = Booking::query()->create([
        'reference' => 'GS-2026-000001',
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'whatsapp' => '+237699000000',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'service_id' => $inspectionService->id,
        'vehicle_registration' => 'CE123AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'confirmed_date' => '2026-07-21',
        'confirmed_time_slot' => '10h00-11h00',
        'status' => BookingStatus::Confirmed,
        'internal_notes' => 'Internal scheduling note',
        'public_message' => 'Votre rendez-vous est confirme.',
    ]);

    if ($createDocumentReadiness) {
        DocumentReadiness::query()->create([
            'booking_id' => $booking->id,
            'status' => DocumentReadinessStatus::ReadyForVisit,
            'missing_information_note' => 'Private missing information note',
            'next_action_fr' => 'Presentez-vous avec vos documents originaux.',
            'next_action_en' => 'Please come with your original documents.',
            'public_message_fr' => 'Vos documents semblent prets.',
            'public_message_en' => 'Your documents appear ready.',
        ]);
    }

    return $booking;
}
