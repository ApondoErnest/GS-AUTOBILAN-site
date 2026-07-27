<?php

use App\Enums\DocumentReadinessStatus;
use App\Events\BookingCreated;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\DocumentReadiness;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('submits the public booking form through BookingService and shows the generated reference', function () {
    Carbon::setTestNow('2026-07-12 10:00:00');
    Event::fake([BookingCreated::class]);

    [$agency, $service] = s066BookingDependencies();

    $response = $this->from('/fr/rendez-vous')->post('/fr/rendez-vous', [
        'agency' => 'nkolbisson',
        'service_type' => 'periodic',
        'vehicle_category' => 'light',
        'vehicle_registration' => ' ce 123 ab ',
        'vehicle_brand' => ' Toyota ',
        'vehicle_model' => ' Corolla ',
        'vehicle_year' => '2020',
        'preferred_date' => '2026-07-13',
        'preferred_time_slot' => 'Matin — 07h00 à 11h00',
        'customer_name' => ' Client GS ',
        'phone' => ' +237 699 000 000 ',
        'whatsapp' => ' +237 699 000 001 ',
        'email' => 'client@example.test',
        'contact_mode' => 'WhatsApp',
        'customer_message' => ' Prefer morning. ',
        'confirmation_understood' => '1',
    ]);

    $response
        ->assertRedirect('/fr/rendez-vous')
        ->assertSessionHas(
            'booking_confirmation',
            fn (array $confirmation): bool => $confirmation['reference'] === 'GS-2026-000001'
                && $confirmation['summary_url'] === '/fr/rendez-vous/GS-2026-000001/recapitulatif.pdf'
                && str_contains($confirmation['tracking_url'], '/fr/suivi-rendez-vous?')
                && str_contains($confirmation['tracking_url'], 'reference=GS-2026-000001')
                && str_contains($confirmation['tracking_url'], 'phone=%2B237699000000')
                && str_contains($confirmation['tracking_url'], 'vehicle_registration=CE123AB')
                && $confirmation['tracking'] === [
                    'reference' => 'GS-2026-000001',
                    'phone' => '+237699000000',
                    'vehicle_registration' => 'CE123AB',
                ],
        );

    $booking = Booking::query()->firstOrFail();

    expect($booking->reference)->toBe('GS-2026-000001');
    expect($booking->agency_id)->toBe($agency->id);
    expect($booking->service_id)->toBe($service->id);
    expect($booking->vehicle_registration)->toBe('CE123AB');
    expect($booking->vehicle_category)->toBe('light');
    expect($booking->vehicle_brand_model)->toBe('Toyota Corolla 2020');
    expect($booking->customer_message)->toContain('Prestation: Visite technique périodique');
    expect($booking->customer_message)->toContain('Contact privilégié: WhatsApp');
    expect($booking->documentReadiness)->toBeInstanceOf(DocumentReadiness::class);
    expect($booking->documentReadiness->status)->toBe(DocumentReadinessStatus::NotReviewed);

    $this->assertDatabaseHas('document_readiness', [
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::NotReviewed->value,
    ]);

    Event::assertDispatched(
        BookingCreated::class,
        fn (BookingCreated $event): bool => $event->booking->is($booking)
            && $event->booking->reference === 'GS-2026-000001',
    );

    $this->get('/fr/rendez-vous')
        ->assertOk()
        ->assertSee('data-booking-confirmation-screen', false)
        ->assertSee('GS-2026-000001', false)
        ->assertSee('Demande de passage enregistrée', false)
        ->assertSee('Prochaines étapes', false)
        ->assertSee('Conservez votre référence', false)
        ->assertSee('Informations de suivi', false)
        ->assertSee('Téléphone utilisé', false)
        ->assertSee('+237699000000', false)
        ->assertSee('CE123AB', false)
        ->assertSee('href="/fr/suivi-rendez-vous?reference=GS-2026-000001&amp;phone=%2B237699000000&amp;vehicle_registration=CE123AB"', false);

    $pdfResponse = $this->get('/fr/rendez-vous/GS-2026-000001/recapitulatif.pdf');

    $pdfResponse
        ->assertOk()
        ->assertHeader('content-type', 'application/pdf');

    expect($pdfResponse->content())->toStartWith('%PDF');
});

function s066BookingDependencies(): array
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
