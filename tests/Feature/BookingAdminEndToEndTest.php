<?php

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Events\BookingCreated;
use App\Filament\Resources\BookingResource\Pages\EditBooking;
use App\Filament\Resources\BookingResource\Pages\ListBookings;
use App\Models\Agency;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

afterEach(function () {
    Carbon::setTestNow();
});

it('lets assigned staff manage a public booking through every operational status', function () {
    Carbon::setTestNow('2026-07-27 09:00:00');
    Event::fake([BookingCreated::class]);

    $agency = s068Agency('nkolbisson', 1);
    $service = s068Service();

    $this->post('/fr/rendez-vous', [
        'agency' => 'nkolbisson',
        'service_type' => 'periodic',
        'vehicle_category' => 'light',
        'vehicle_registration' => ' ce 068 ab ',
        'vehicle_brand' => ' Toyota ',
        'vehicle_model' => ' Hilux ',
        'vehicle_year' => '2023',
        'preferred_date' => '2026-07-29',
        'preferred_time_slot' => 'Matin - 07h00 a 11h00',
        'customer_name' => ' Client S068 ',
        'phone' => ' +237 699 068 000 ',
        'whatsapp' => ' +237 699 068 001 ',
        'email' => 'client-s068@example.test',
        'contact_mode' => 'WhatsApp',
        'confirmation_understood' => '1',
    ])->assertRedirect('/fr/rendez-vous');

    $booking = Booking::query()->where('customer_name', 'Client S068')->firstOrFail();

    expect($booking)
        ->reference->toBe('GS-2026-000001')
        ->status->toBe(BookingStatus::NewRequest)
        ->vehicle_registration->toBe('CE068AB')
        ->service_id->toBe($service->id)
        ->and($booking->documentReadiness)
        ->status->toBe(DocumentReadinessStatus::NotReviewed);

    s068ActingAs(s068User('agency_admin', $agency));

    $this->get('/admin/bookings')->assertOk();
    $this->get("/admin/bookings/{$booking->id}/edit")->assertOk();

    Livewire::test(ListBookings::class)
        ->assertCanSeeTableRecords([$booking])
        ->assertTableColumnFormattedStateSet('status', __('admin_bookings.statuses.booking.new_request'), $booking);

    Livewire::test(EditBooking::class, ['record' => $booking->id])
        ->fillForm([
            'status' => BookingStatus::PendingConfirmation->value,
            'public_message' => 'Votre demande est en cours de verification.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($booking->fresh())
        ->status->toBe(BookingStatus::PendingConfirmation)
        ->public_message->toBe('Votre demande est en cours de verification.');

    Livewire::test(EditBooking::class, ['record' => $booking->id])
        ->fillForm([
            'status' => BookingStatus::Confirmed->value,
            'confirmed_date' => '2026-07-30',
            'confirmed_time_slot' => '08h00-09h00',
            'public_message' => 'Votre rendez-vous est confirme.',
            'internal_notes' => 'Confirmation faite par telephone.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($booking->fresh())
        ->status->toBe(BookingStatus::Confirmed)
        ->confirmed_date->toDateString()->toBe('2026-07-30')
        ->confirmed_time_slot->toBe('08h00-09h00')
        ->public_message->toBe('Votre rendez-vous est confirme.')
        ->internal_notes->toBe('Confirmation faite par telephone.');

    foreach ([BookingStatus::Rescheduled, BookingStatus::Cancelled, BookingStatus::Completed, BookingStatus::NoShow] as $status) {
        Livewire::test(EditBooking::class, ['record' => $booking->id])
            ->fillForm([
                'status' => $status->value,
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($booking->fresh())
            ->status->toBe($status)
            ->confirmed_date->toDateString()->toBe('2026-07-30')
            ->confirmed_time_slot->toBe('08h00-09h00');
    }

    Livewire::test(ListBookings::class)
        ->assertTableColumnFormattedStateSet('status', __('admin_bookings.statuses.booking.no_show'), $booking->fresh());
});

function s068ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s068User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s068Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678000001'],
        'whatsapp' => '+237678000001',
        'email' => $slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s068Service(): Service
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
