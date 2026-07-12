<?php

use App\Http\Requests\BookingRequest;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Requests\TrackingLookupRequest;
use App\Models\Agency;
use App\Models\Service;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

beforeEach(function () {
    $withoutCsrf = [
        ValidateCsrfToken::class,
        VerifyCsrfToken::class,
    ];

    Route::post('/_s046/booking', fn (BookingRequest $request) => response()->json($request->validated()))
        ->middleware('web')
        ->withoutMiddleware($withoutCsrf);

    Route::post('/_s046/tracking', fn (TrackingLookupRequest $request) => response()->json($request->validated()))
        ->middleware('web')
        ->withoutMiddleware($withoutCsrf);

    Route::post('/_s046/contact', fn (ContactMessageRequest $request) => response()->json($request->validated()))
        ->middleware('web')
        ->withoutMiddleware($withoutCsrf);
});

afterEach(function () {
    Carbon::setTestNow();
});

it('validates and normalizes booking requests', function () {
    Carbon::setTestNow('2026-07-12 10:00:00');
    [$agency, $service] = s046ActiveAgencyAndService();

    $response = $this->postJson('/_s046/booking', [
        'customer_name' => '  Client GS  ',
        'phone' => ' +237 699 000 000 ',
        'whatsapp' => ' +237 699 000 001 ',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => ' ce 123 ab ',
        'vehicle_type' => ' Car ',
        'vehicle_category' => ' light ',
        'vehicle_brand_model' => ' Toyota Corolla ',
        'preferred_date' => '2026-07-13',
        'preferred_time_slot' => ' 09h00-10h00 ',
        'customer_message' => ' Prefer morning. ',
    ]);

    $response->assertOk()
        ->assertJsonPath('customer_name', 'Client GS')
        ->assertJsonPath('phone', '+237699000000')
        ->assertJsonPath('whatsapp', '+237699000001')
        ->assertJsonPath('vehicle_registration', 'CE123AB')
        ->assertJsonPath('vehicle_type', 'Car')
        ->assertJsonPath('vehicle_category', 'light')
        ->assertJsonPath('vehicle_brand_model', 'Toyota Corolla')
        ->assertJsonPath('preferred_time_slot', '09h00-10h00')
        ->assertJsonPath('customer_message', 'Prefer morning.');
});

it('rejects invalid booking request data', function () {
    Carbon::setTestNow('2026-07-12 10:00:00');
    [$agency, $service] = s046ActiveAgencyAndService();

    $agency->forceFill(['is_active' => false])->save();
    $service->forceFill(['is_active' => false])->save();

    $this->post('/_s046/booking', [
        'customer_name' => '',
        'phone' => 'abc',
        'email' => 'not-an-email',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => '',
        'preferred_date' => '2026-07-11',
        'preferred_time_slot' => '',
    ])->assertRedirect()
        ->assertInvalid([
            'customer_name',
            'phone',
            'email',
            'agency_id',
            'service_id',
            'vehicle_registration',
            'preferred_date',
            'preferred_time_slot',
        ]);
});

it('validates and normalizes tracking lookup requests', function () {
    $this->withHeaders(['Accept' => 'application/json'])->postJson('/_s046/tracking', [
        'reference' => ' gs-2026-000001 ',
        'phone' => '+237 699 000 000',
        'vehicle_registration' => ' ce 123 ab ',
    ])->assertOk()
        ->assertJsonPath('reference', 'GS-2026-000001')
        ->assertJsonPath('phone', '+237699000000')
        ->assertJsonPath('vehicle_registration', 'CE123AB');

    $this->post('/_s046/tracking', [
        'reference' => '2026-000001',
        'phone' => '',
        'vehicle_registration' => '',
    ])->assertRedirect()
        ->assertInvalid(['reference', 'phone', 'vehicle_registration']);
});

it('validates contact messages with phone or email and optional active agency', function () {
    [$agency] = s046ActiveAgencyAndService();

    $this->postJson('/_s046/contact', [
        'name' => ' Client Contact ',
        'phone' => ' +237 677 000 000 ',
        'email' => '',
        'agency_id' => $agency->id,
        'subject' => ' Renseignement ',
        'message' => ' Je voudrais des informations. ',
    ])->assertOk()
        ->assertJsonPath('name', 'Client Contact')
        ->assertJsonPath('phone', '+237677000000')
        ->assertJsonPath('email', null)
        ->assertJsonPath('subject', 'Renseignement')
        ->assertJsonPath('message', 'Je voudrais des informations.');

    $this->postJson('/_s046/contact', [
        'name' => 'Client Contact',
        'email' => 'client@example.test',
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
    ])->assertOk()
        ->assertJsonPath('email', 'client@example.test')
        ->assertJsonPath('phone', null);
});

it('rejects invalid contact messages', function () {
    [$agency] = s046ActiveAgencyAndService();
    $agency->forceFill(['is_active' => false])->save();

    $this->post('/_s046/contact', [
        'name' => '',
        'phone' => '',
        'email' => '',
        'agency_id' => $agency->id,
        'subject' => '',
        'message' => '',
    ])->assertRedirect()
        ->assertInvalid([
            'name',
            'phone',
            'email',
            'agency_id',
            'subject',
            'message',
        ]);
});

function s046ActiveAgencyAndService(): array
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

    $service = Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
    ]);

    return [$agency, $service];
}
