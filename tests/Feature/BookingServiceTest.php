<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\Setting;
use App\Services\BookingService;
use App\Services\DocumentReadinessService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('creates a booking with a generated reference and default document readiness', function () {
    Carbon::setTestNow('2026-07-11 12:00:00');
    [$agency, $inspectionService] = s042BookingDependencies();

    $booking = app(BookingService::class)->create([
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'whatsapp' => '+237699000001',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'service_id' => $inspectionService->id,
        'vehicle_registration' => 'CE123AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'customer_message' => 'Prefer morning.',
    ]);

    expect($booking->reference)->toBe('GS-2026-000001');
    expect($booking->status)->toBe(BookingStatus::NewRequest);
    expect($booking->documentReadiness)->toBeInstanceOf(DocumentReadiness::class);
    expect($booking->documentReadiness->status)->toBe(DocumentReadinessStatus::NotReviewed);

    $this->assertDatabaseHas('bookings', [
        'reference' => 'GS-2026-000001',
        'status' => BookingStatus::NewRequest->value,
        'customer_name' => 'Client GS',
    ]);

    $this->assertDatabaseHas('document_readiness', [
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::NotReviewed->value,
    ]);
});

it('generates a new unique reference for each created booking', function () {
    Carbon::setTestNow('2026-07-11 12:00:00');
    [$agency, $inspectionService] = s042BookingDependencies();

    $first = app(BookingService::class)->create(s042BookingPayload($agency, $inspectionService));
    $second = app(BookingService::class)->create([
        ...s042BookingPayload($agency, $inspectionService),
        'vehicle_registration' => 'CE456CD',
    ]);

    expect($first->reference)->toBe('GS-2026-000001');
    expect($second->reference)->toBe('GS-2026-000002');
    expect(DocumentReadiness::query()->count())->toBe(2);
});

it('does not create duplicate document readiness for the same booking', function () {
    [$agency, $inspectionService] = s042BookingDependencies();
    $booking = app(BookingService::class)->create(s042BookingPayload($agency, $inspectionService));

    $first = app(DocumentReadinessService::class)->createDefaultFor($booking);
    $second = app(DocumentReadinessService::class)->createDefaultFor($booking);

    expect($first->is($second))->toBeTrue();
    expect(DocumentReadiness::query()->where('booking_id', $booking->id)->count())->toBe(1);
});

it('rolls back the reference sequence if booking creation fails', function () {
    Carbon::setTestNow('2026-07-11 12:00:00');

    expect(fn () => app(BookingService::class)->create([
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'agency_id' => 999,
        'service_id' => 999,
        'vehicle_registration' => 'CE123AB',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
    ]))->toThrow(QueryException::class);

    expect(Booking::query()->count())->toBe(0);
    expect(Setting::query()->where('key', 'booking_reference_sequence_2026')->exists())->toBeFalse();
});

function s042BookingPayload(Agency $agency, Service $inspectionService): array
{
    return [
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'agency_id' => $agency->id,
        'service_id' => $inspectionService->id,
        'vehicle_registration' => 'CE123AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
    ];
}

function s042BookingDependencies(): array
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

    return [$agency, $inspectionService];
}
