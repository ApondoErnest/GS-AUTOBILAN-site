<?php

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\ContactStatus;
use App\Enums\DocumentReadinessStatus;
use App\Filament\Pages\Dashboard;
use App\Filament\Support\DashboardMetrics;
use App\Filament\Widgets\BookingAgencyBreakdown;
use App\Filament\Widgets\BookingKpiOverview;
use App\Filament\Widgets\DashboardActivityWidget;
use App\Filament\Widgets\DashboardAlertsOverview;
use App\Models\Agency;
use App\Models\Article;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DocumentReadiness;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

it('registers the S050 dashboard overview widgets', function () {
    expect((new Dashboard)->getWidgets())->toContain(
        BookingKpiOverview::class,
        BookingAgencyBreakdown::class,
        DashboardAlertsOverview::class,
        DashboardActivityWidget::class,
    );
});

it('renders the S050 dashboard widgets for super admins', function () {
    s050SeedDashboardData();
    $superAdmin = s050User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin')
        ->assertOk()
        ->assertSee('Booking KPIs')
        ->assertSee('Latest activity');
});

it('counts booking KPIs across all agencies for super admins', function () {
    $data = s050SeedDashboardData();
    $superAdmin = s050User('super_admin');

    expect(DashboardMetrics::bookingCounts($superAdmin))->toMatchArray([
        'total' => 7,
        'new' => 2,
        'pending' => 1,
        'confirmed' => 2,
        'completed' => 1,
        'no_show' => 1,
    ]);

    expect(DashboardMetrics::agencyBookingBreakdown($superAdmin)->all())->toBe([
        ['label' => $data['agency']->name_fr, 'count' => 5],
        ['label' => $data['otherAgency']->name_fr, 'count' => 2],
    ]);
});

it('scopes booking KPIs to the assigned agency for agency admins', function () {
    $data = s050SeedDashboardData();
    $agencyAdmin = s050User('agency_admin', $data['agency']);

    expect(DashboardMetrics::bookingCounts($agencyAdmin))->toMatchArray([
        'total' => 5,
        'new' => 1,
        'pending' => 1,
        'confirmed' => 1,
        'completed' => 1,
        'no_show' => 1,
    ]);

    expect(DashboardMetrics::agencyBookingBreakdown($agencyAdmin)->all())->toBe([
        ['label' => $data['agency']->name_fr, 'count' => 5],
    ]);
});

it('hides operational dashboard metrics from agency admins without an assigned agency', function () {
    s050SeedDashboardData();
    $agencyAdmin = s050User('agency_admin');

    expect(DashboardMetrics::canViewOperations($agencyAdmin))->toBeFalse();
    expect(DashboardMetrics::bookingCounts($agencyAdmin))->toMatchArray([
        'total' => 0,
        'new' => 0,
        'pending' => 0,
        'confirmed' => 0,
        'completed' => 0,
        'no_show' => 0,
    ]);
});

it('scopes operational alerts while leaving content alerts to content roles', function () {
    $data = s050SeedDashboardData();
    $superAdmin = s050User('super_admin');
    $agencyAdmin = s050User('agency_admin', $data['agency']);
    $contentManager = s050User('content_manager');

    expect(DashboardMetrics::alertCounts($superAdmin))->toMatchArray([
        'missing_info' => 2,
        'contact_agency' => 2,
        'new_contacts' => 2,
        'latest_articles' => 1,
    ]);

    expect(DashboardMetrics::alertCounts($agencyAdmin))->toMatchArray([
        'missing_info' => 1,
        'contact_agency' => 1,
        'new_contacts' => 1,
    ]);

    expect(DashboardMetrics::canViewContent($contentManager))->toBeTrue();
    expect(DashboardMetrics::alertCounts($contentManager))->toMatchArray([
        'missing_info' => 0,
        'contact_agency' => 0,
        'new_contacts' => 0,
        'latest_articles' => 1,
    ]);

    expect(DashboardMetrics::latestContactMessages($agencyAdmin))->toHaveCount(2);
    expect(DashboardMetrics::latestArticles())->toHaveCount(3);
});

/**
 * @return array{agency: Agency, otherAgency: Agency, service: Service}
 */
function s050SeedDashboardData(): array
{
    $agency = s050Agency('nkolbisson', 1);
    $otherAgency = s050Agency('obili-scalom', 2);
    $service = s050Service();

    $agencyBookings = [
        s050Booking($agency, $service, BookingStatus::NewRequest),
        s050Booking($agency, $service, BookingStatus::PendingConfirmation),
        s050Booking($agency, $service, BookingStatus::Confirmed),
        s050Booking($agency, $service, BookingStatus::Completed),
        s050Booking($agency, $service, BookingStatus::NoShow),
    ];

    $otherAgencyBookings = [
        s050Booking($otherAgency, $service, BookingStatus::NewRequest),
        s050Booking($otherAgency, $service, BookingStatus::Confirmed),
    ];

    s050DocumentReadiness($agencyBookings[0], DocumentReadinessStatus::MissingInfo);
    s050DocumentReadiness($agencyBookings[1], DocumentReadinessStatus::ContactAgency);
    s050DocumentReadiness($otherAgencyBookings[0], DocumentReadinessStatus::MissingInfo);
    s050DocumentReadiness($otherAgencyBookings[1], DocumentReadinessStatus::ContactAgency);

    s050ContactMessage($agency, ContactStatus::New);
    s050ContactMessage($agency, ContactStatus::Responded);
    s050ContactMessage($otherAgency, ContactStatus::New);
    s050Article(ArticleStatus::Published, now()->subDay());
    s050Article(ArticleStatus::Draft);
    s050Article(ArticleStatus::Published, now()->addDay());

    return compact('agency', 'otherAgency', 'service');
}

function s050User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s050Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug.'-'.str()->uuid(),
        'address_fr' => 'Carrefour Onana',
        'address_en' => 'Onana junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678844791'],
        'whatsapp' => '+237678844791',
        'email' => $slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
    ]);
}

function s050Service(): Service
{
    return Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers-'.str()->uuid(),
        'slug_en' => 'light-vehicles-'.str()->uuid(),
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
    ]);
}

function s050Booking(Agency $agency, Service $service, BookingStatus $status): Booking
{
    return Booking::query()->create([
        'reference' => 'GS-2026-'.str()->upper(str()->random(8)),
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE'.random_int(1000, 9999).'AB',
        'vehicle_type' => 'Car',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'status' => $status,
    ]);
}

function s050DocumentReadiness(Booking $booking, DocumentReadinessStatus $status): DocumentReadiness
{
    return DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => $status,
    ]);
}

function s050ContactMessage(Agency $agency, ContactStatus $status): ContactMessage
{
    return ContactMessage::query()->create([
        'name' => 'Client Contact',
        'phone' => '+237677000000',
        'agency_id' => $agency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'status' => $status,
    ]);
}

function s050Article(ArticleStatus $status, mixed $publishedAt = null): Article
{
    return Article::query()->create([
        'title_fr' => 'Preparer sa visite '.str()->uuid(),
        'title_en' => 'Prepare your visit '.str()->uuid(),
        'slug_fr' => 'preparer-sa-visite-'.str()->uuid(),
        'slug_en' => 'prepare-your-visit-'.str()->uuid(),
        'content_fr' => 'Contenu FR.',
        'content_en' => 'EN content.',
        'status' => $status,
        'published_at' => $publishedAt,
    ]);
}
