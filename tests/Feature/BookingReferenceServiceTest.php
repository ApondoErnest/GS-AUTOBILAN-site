<?php

use App\Models\Agency;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Setting;
use App\Services\BookingReferenceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('generates sequential booking references for the current year', function () {
    Carbon::setTestNow('2026-07-11 12:00:00');

    $service = app(BookingReferenceService::class);

    expect($service->generate())->toBe('GS-2026-000001');
    expect($service->generate())->toBe('GS-2026-000002');

    expect(Setting::query()->where('key', 'booking_reference_sequence_2026')->first()->value)
        ->toBe([
            'year' => 2026,
            'last' => 2,
        ]);
});

it('keeps independent sequences per year', function () {
    $service = app(BookingReferenceService::class);

    expect($service->generate(2026))->toBe('GS-2026-000001');
    expect($service->generate(2027))->toBe('GS-2027-000001');
    expect($service->generate(2026))->toBe('GS-2026-000002');
});

it('skips existing booking references when the database is ahead of the stored sequence', function () {
    [$agency, $inspectionService] = s041BookingDependencies();

    Setting::query()->create([
        'key' => 'booking_reference_sequence_2026',
        'value' => [
            'year' => 2026,
            'last' => 5,
        ],
    ]);

    Booking::query()->create([
        'reference' => 'GS-2026-000006',
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'agency_id' => $agency->id,
        'service_id' => $inspectionService->id,
        'vehicle_registration' => 'CE123AB',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
    ]);

    expect(app(BookingReferenceService::class)->generate(2026))->toBe('GS-2026-000007');
});

it('formats explicit sequence numbers', function () {
    expect(app(BookingReferenceService::class)->format(2026, 123))
        ->toBe('GS-2026-000123');
});

function s041BookingDependencies(): array
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
