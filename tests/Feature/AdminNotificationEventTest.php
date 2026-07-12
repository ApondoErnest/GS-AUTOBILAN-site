<?php

use App\Events\BookingCreated;
use App\Events\ContactMessageCreated;
use App\Listeners\SendAdminBookingNotification;
use App\Listeners\SendAdminContactMessageNotification;
use App\Models\Agency;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use App\Notifications\NewBookingAdminNotification;
use App\Notifications\NewContactMessageAdminNotification;
use App\Services\BookingService;
use App\Services\ContactMessageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

afterEach(function () {
    Carbon::setTestNow();
});

it('registers booking and contact event listeners', function () {
    Event::fake();

    Event::assertListening(BookingCreated::class, SendAdminBookingNotification::class);
    Event::assertListening(ContactMessageCreated::class, SendAdminContactMessageNotification::class);
});

it('dispatches booking and contact created events from the services', function () {
    Carbon::setTestNow('2026-07-12 09:00:00');
    Event::fake([BookingCreated::class, ContactMessageCreated::class]);

    [$agency, $service] = s047BookingDependencies();

    $booking = app(BookingService::class)->create(s047BookingPayload($agency, $service));
    $contactMessage = app(ContactMessageService::class)->create(s047ContactPayload($agency));

    Event::assertDispatched(
        BookingCreated::class,
        fn (BookingCreated $event): bool => $event->booking->is($booking)
            && $event->booking->reference === 'GS-2026-000001',
    );

    Event::assertDispatched(
        ContactMessageCreated::class,
        fn (ContactMessageCreated $event): bool => $event->contactMessage->is($contactMessage),
    );
});

it('sends on-demand admin notifications to the configured admin email', function () {
    Carbon::setTestNow('2026-07-12 09:00:00');
    Notification::fake();

    Setting::query()->create([
        'key' => 'direction_generale',
        'value' => [
            'email' => 'admin@example.test',
        ],
    ]);

    [$agency, $service] = s047BookingDependencies();

    $booking = app(BookingService::class)->create(s047BookingPayload($agency, $service));
    $contactMessage = app(ContactMessageService::class)->create(s047ContactPayload($agency));

    Notification::assertSentOnDemand(
        NewBookingAdminNotification::class,
        fn (
            NewBookingAdminNotification $notification,
            array $channels,
            AnonymousNotifiable $notifiable,
        ): bool => $notification->booking->is($booking)
            && $channels === ['mail']
            && $notifiable->routeNotificationFor('mail') === 'admin@example.test',
    );

    Notification::assertSentOnDemand(
        NewContactMessageAdminNotification::class,
        fn (
            NewContactMessageAdminNotification $notification,
            array $channels,
            AnonymousNotifiable $notifiable,
        ): bool => $notification->contactMessage->is($contactMessage)
            && $channels === ['mail']
            && $notifiable->routeNotificationFor('mail') === 'admin@example.test',
    );
});

it('builds mail messages with operational booking and contact context', function () {
    Carbon::setTestNow('2026-07-12 09:00:00');
    [$agency, $service] = s047BookingDependencies();

    $booking = app(BookingService::class)->create(s047BookingPayload($agency, $service));
    $contactMessage = ContactMessage::query()->create([
        ...s047ContactPayload($agency),
        'status' => 'new',
    ]);

    $bookingMail = (new NewBookingAdminNotification($booking))->toMail(new AnonymousNotifiable);
    $contactMail = (new NewContactMessageAdminNotification($contactMessage))->toMail(new AnonymousNotifiable);

    expect($bookingMail->subject)->toBe('Nouvelle demande de rendez-vous GS-2026-000001');
    expect($bookingMail->introLines)->toContain('Client: Client GS');
    expect($bookingMail->introLines)->toContain('Agence: GS AUTOBILAN Nkolbisson');
    expect($bookingMail->introLines)->toContain('Service: Vehicules legers');

    expect($contactMail->subject)->toBe('Nouveau message de contact GS AUTOBILAN');
    expect($contactMail->introLines)->toContain('Nom: Client Contact');
    expect($contactMail->introLines)->toContain('Email: client@example.test');
    expect($contactMail->introLines)->toContain('Agence: GS AUTOBILAN Nkolbisson');
});

function s047BookingPayload(Agency $agency, Service $service): array
{
    return [
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'whatsapp' => '+237699000001',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE123AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'customer_message' => 'Prefer morning.',
    ];
}

function s047ContactPayload(Agency $agency): array
{
    return [
        'name' => 'Client Contact',
        'phone' => '+237677000000',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
    ];
}

function s047BookingDependencies(): array
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
