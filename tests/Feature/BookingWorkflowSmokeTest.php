<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Events\BookingCreated;
use App\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Filament\Resources\DocumentReadinessResource\Pages\EditDocumentReadiness;
use App\Http\Middleware\ThrottlePublicFormSubmission;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }

    RateLimiter::clear(ThrottlePublicFormSubmission::limiterKey('booking', '127.0.0.1'));
    RateLimiter::clear('tracking-lookup|127.0.0.1');
});

afterEach(function () {
    Carbon::setTestNow();
});

it('passes the S080 public booking to admin confirmation to tracking happy path', function () {
    Carbon::setTestNow('2026-07-29 09:00:00');
    Event::fake([BookingCreated::class]);

    $agency = s080Agency('nkolbisson');
    $service = s080Service();

    $this->from('/fr/rendez-vous')
        ->post('/fr/rendez-vous', [
            'agency' => $agency->slug,
            'service_type' => 'periodic',
            'vehicle_category' => 'light',
            'vehicle_registration' => ' ce 080 ab ',
            'vehicle_brand' => ' Toyota ',
            'vehicle_model' => ' Corolla ',
            'vehicle_year' => '2024',
            'preferred_date' => '2026-08-01',
            'preferred_time_slot' => 'Matin - 07h00 a 11h00',
            'customer_name' => ' Client S080 ',
            'phone' => ' +237 699 080 000 ',
            'whatsapp' => ' +237 699 080 001 ',
            'email' => 'client-s080@example.test',
            'contact_mode' => 'WhatsApp',
            'customer_message' => 'Merci de confirmer le passage.',
            'confirmation_understood' => '1',
        ])
        ->assertRedirect('/fr/rendez-vous')
        ->assertSessionHas('booking_confirmation', fn (array $confirmation): bool => $confirmation['reference'] === 'GS-2026-000001'
            && str_contains($confirmation['tracking_url'], '/fr/suivi-rendez-vous?')
            && $confirmation['tracking'] === [
                'reference' => 'GS-2026-000001',
                'phone' => '+237699080000',
                'vehicle_registration' => 'CE080AB',
            ]);

    $booking = Booking::query()->where('reference', 'GS-2026-000001')->firstOrFail();
    $readiness = $booking->documentReadiness()->firstOrFail();

    expect($booking)
        ->customer_name->toBe('Client S080')
        ->status->toBe(BookingStatus::NewRequest)
        ->agency_id->toBe($agency->id)
        ->service_id->toBe($service->id)
        ->vehicle_registration->toBe('CE080AB')
        ->and($readiness->status)->toBe(DocumentReadinessStatus::NotReviewed);

    Event::assertDispatched(
        BookingCreated::class,
        fn (BookingCreated $event): bool => $event->booking->is($booking),
    );

    $staff = s080User('agency_admin', $agency);
    s080ActingAs($staff);

    $this->get('/admin/bookings')->assertOk();
    $this->get("/admin/bookings/{$booking->id}/edit")->assertOk();

    Livewire::test(ListBookings::class)
        ->assertCanSeeTableRecords([$booking])
        ->assertTableColumnFormattedStateSet('status', 'New request', $booking);

    Livewire::test(EditBooking::class, ['record' => $booking->id])
        ->fillForm([
            'status' => BookingStatus::Confirmed->value,
            'confirmed_date' => '2026-08-02',
            'confirmed_time_slot' => '08h00-09h00',
            'public_message' => 'Votre rendez-vous est confirme.',
            'internal_notes' => 'Appel de confirmation effectue.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    Livewire::test(EditDocumentReadiness::class, ['record' => $readiness->id])
        ->fillForm([
            'status' => DocumentReadinessStatus::ReadyForVisit->value,
            'missing_information_note' => 'Note interne non publique.',
            'next_action_fr' => 'Presentez les originaux a la reception.',
            'next_action_en' => 'Bring the originals to reception.',
            'public_message_fr' => 'Votre dossier est pret pour le passage.',
            'public_message_en' => 'Your file is ready for the visit.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $booking = $booking->fresh();
    $readiness = $readiness->fresh();

    expect($booking)
        ->status->toBe(BookingStatus::Confirmed)
        ->confirmed_date->toDateString()->toBe('2026-08-02')
        ->confirmed_time_slot->toBe('08h00-09h00')
        ->public_message->toBe('Votre rendez-vous est confirme.')
        ->internal_notes->toBe('Appel de confirmation effectue.')
        ->and($readiness)
        ->status->toBe(DocumentReadinessStatus::ReadyForVisit)
        ->updated_by->toBe($staff->id);

    $this->post('/fr/suivi-rendez-vous', [
        'reference' => ' gs-2026-000001 ',
        'phone' => '+237 699 080 000',
        'vehicle_registration' => ' ce 080 ab ',
    ])
        ->assertOk()
        ->assertSee('data-tracking-result', false)
        ->assertSee('GS-2026-000001', false)
        ->assertSee('GS AUTOBILAN Nkolbisson', false)
        ->assertSee('02/08/2026', false)
        ->assertSee('08h00-09h00', false)
        ->assertSee('Confirmé', false)
        ->assertSee('Prêt pour le passage', false)
        ->assertSee('Votre rendez-vous est confirme.', false)
        ->assertSee('Presentez les originaux a la reception.', false)
        ->assertSee('Votre dossier est pret pour le passage.', false)
        ->assertSee('href="/fr/rendez-vous/GS-2026-000001/recapitulatif.pdf"', false)
        ->assertDontSee('Client S080', false)
        ->assertDontSee('client-s080@example.test', false)
        ->assertDontSee('Appel de confirmation effectue.', false)
        ->assertDontSee('Note interne non publique.', false);
});

function s080ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s080User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s080Agency(string $slug): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN Nkolbisson',
        'name_en' => 'GS AUTOBILAN Nkolbisson',
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
        'status' => 'operational',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

function s080Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
        'is_active' => true,
    ]);
}
