<?php

use App\Enums\ArticleStatus;
use App\Enums\BookingStatus;
use App\Enums\ContactStatus;
use App\Enums\DocumentReadinessStatus;
use App\Enums\GalleryCategory;
use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\DocumentReadiness;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\Testimonial;
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

it('allows super admins to manage every protected backend model', function () {
    $entities = s045Entities();
    $superAdmin = s045User('super_admin');

    expect($superAdmin->can('viewAny', Agency::class))->toBeTrue();
    expect($superAdmin->can('update', $entities['agency']))->toBeTrue();
    expect($superAdmin->can('create', Booking::class))->toBeTrue();
    expect($superAdmin->can('delete', $entities['booking']))->toBeTrue();
    expect($superAdmin->can('update', $entities['documentReadiness']))->toBeTrue();
    expect($superAdmin->can('update', $entities['contactMessage']))->toBeTrue();
    expect($superAdmin->can('create', Service::class))->toBeTrue();
    expect($superAdmin->can('update', $entities['service']))->toBeTrue();
    expect($superAdmin->can('create', Article::class))->toBeTrue();
    expect($superAdmin->can('update', $entities['article']))->toBeTrue();
    expect($superAdmin->can('update', $entities['articleCategory']))->toBeTrue();
    expect($superAdmin->can('update', $entities['faq']))->toBeTrue();
    expect($superAdmin->can('update', $entities['galleryItem']))->toBeTrue();
    expect($superAdmin->can('update', $entities['testimonial']))->toBeTrue();
    expect($superAdmin->can('update', $entities['tariff']))->toBeTrue();
    expect($superAdmin->can('update', $entities['setting']))->toBeTrue();
    expect($superAdmin->can('update', $entities['staffUser']))->toBeTrue();
});

it('scopes agency admins to their own agency operations only', function () {
    $entities = s045Entities();
    $agencyAdmin = s045User('agency_admin', $entities['agency']);

    expect($agencyAdmin->can('viewAny', Agency::class))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['agency']))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['otherAgency']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['agency']))->toBeFalse();

    expect($agencyAdmin->can('viewAny', Booking::class))->toBeTrue();
    expect($agencyAdmin->can('create', Booking::class))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['booking']))->toBeTrue();
    expect($agencyAdmin->can('update', $entities['booking']))->toBeTrue();
    expect($agencyAdmin->can('delete', $entities['booking']))->toBeFalse();
    expect($agencyAdmin->can('view', $entities['otherBooking']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['otherBooking']))->toBeFalse();

    expect($agencyAdmin->can('viewAny', DocumentReadiness::class))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['documentReadiness']))->toBeTrue();
    expect($agencyAdmin->can('update', $entities['documentReadiness']))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['otherDocumentReadiness']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['otherDocumentReadiness']))->toBeFalse();

    expect($agencyAdmin->can('viewAny', ContactMessage::class))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['contactMessage']))->toBeTrue();
    expect($agencyAdmin->can('update', $entities['contactMessage']))->toBeTrue();
    expect($agencyAdmin->can('view', $entities['otherContactMessage']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['otherContactMessage']))->toBeFalse();
    expect($agencyAdmin->can('view', $entities['unassignedContactMessage']))->toBeFalse();
    expect($agencyAdmin->can('create', ContactMessage::class))->toBeFalse();

    expect($agencyAdmin->can('viewAny', Service::class))->toBeFalse();
    expect($agencyAdmin->can('viewAny', Article::class))->toBeFalse();
    expect($agencyAdmin->can('viewAny', Tariff::class))->toBeFalse();
    expect($agencyAdmin->can('viewAny', Setting::class))->toBeFalse();
    expect($agencyAdmin->can('viewAny', User::class))->toBeFalse();
});

it('denies agency admins without an assigned agency', function () {
    $entities = s045Entities();
    $agencyAdmin = s045User('agency_admin');

    expect($agencyAdmin->can('viewAny', Agency::class))->toBeFalse();
    expect($agencyAdmin->can('viewAny', Booking::class))->toBeFalse();
    expect($agencyAdmin->can('view', $entities['agency']))->toBeFalse();
    expect($agencyAdmin->can('view', $entities['booking']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['documentReadiness']))->toBeFalse();
    expect($agencyAdmin->can('update', $entities['contactMessage']))->toBeFalse();
});

it('allows content managers to manage content and services but not operations or protected admin data', function () {
    $entities = s045Entities();
    $contentManager = s045User('content_manager');

    expect($contentManager->can('viewAny', Service::class))->toBeTrue();
    expect($contentManager->can('create', Service::class))->toBeTrue();
    expect($contentManager->can('update', $entities['service']))->toBeTrue();
    expect($contentManager->can('delete', $entities['service']))->toBeTrue();

    foreach ([
        Article::class => $entities['article'],
        ArticleCategory::class => $entities['articleCategory'],
        Faq::class => $entities['faq'],
        GalleryItem::class => $entities['galleryItem'],
        Testimonial::class => $entities['testimonial'],
    ] as $modelClass => $model) {
        expect($contentManager->can('viewAny', $modelClass))->toBeTrue();
        expect($contentManager->can('create', $modelClass))->toBeTrue();
        expect($contentManager->can('update', $model))->toBeTrue();
        expect($contentManager->can('delete', $model))->toBeTrue();
    }

    expect($contentManager->can('viewAny', Agency::class))->toBeFalse();
    expect($contentManager->can('viewAny', Booking::class))->toBeFalse();
    expect($contentManager->can('update', $entities['booking']))->toBeFalse();
    expect($contentManager->can('update', $entities['documentReadiness']))->toBeFalse();
    expect($contentManager->can('update', $entities['contactMessage']))->toBeFalse();
    expect($contentManager->can('viewAny', Tariff::class))->toBeFalse();
    expect($contentManager->can('update', $entities['tariff']))->toBeFalse();
    expect($contentManager->can('viewAny', Setting::class))->toBeFalse();
    expect($contentManager->can('viewAny', User::class))->toBeFalse();
});

function s045User(string $role, ?Agency $agency = null): User
{
    $user = User::query()->create([
        'name' => str_replace('_', ' ', $role),
        'email' => $role.'-'.str()->uuid().'@example.test',
        'password' => 'password',
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

/**
 * @return array<string, mixed>
 */
function s045Entities(): array
{
    $agency = s045Agency('nkolbisson', 1);
    $otherAgency = s045Agency('obili-scalom', 2);
    $service = Service::query()->create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
    ]);

    $booking = s045Booking($agency, $service, 'GS-2026-000001', 'CE123AB');
    $otherBooking = s045Booking($otherAgency, $service, 'GS-2026-000002', 'CE456CD');

    $documentReadiness = DocumentReadiness::query()->create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::NotReviewed,
    ]);
    $otherDocumentReadiness = DocumentReadiness::query()->create([
        'booking_id' => $otherBooking->id,
        'status' => DocumentReadinessStatus::NotReviewed,
    ]);

    $contactMessage = ContactMessage::query()->create([
        'name' => 'Client Contact',
        'phone' => '+237677000000',
        'agency_id' => $agency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'status' => ContactStatus::New,
    ]);
    $otherContactMessage = ContactMessage::query()->create([
        'name' => 'Client Contact 2',
        'phone' => '+237677000001',
        'agency_id' => $otherAgency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'status' => ContactStatus::New,
    ]);
    $unassignedContactMessage = ContactMessage::query()->create([
        'name' => 'Client Contact 3',
        'phone' => '+237677000002',
        'subject' => 'Renseignement',
        'message' => 'Je voudrais des informations.',
        'status' => ContactStatus::New,
    ]);

    $articleCategory = ArticleCategory::query()->create([
        'name_fr' => 'Conseils',
        'name_en' => 'Advice',
        'slug_fr' => 'conseils',
        'slug_en' => 'advice',
        'sort_order' => 1,
    ]);
    $article = Article::query()->create([
        'category_id' => $articleCategory->id,
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite',
        'slug_en' => 'prepare-your-visit',
        'content_fr' => 'Contenu FR.',
        'content_en' => 'EN content.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);
    $faq = Faq::query()->create([
        'question_fr' => 'Question active ?',
        'question_en' => 'Active question?',
        'answer_fr' => 'Oui.',
        'answer_en' => 'Yes.',
        'sort_order' => 1,
    ]);
    $galleryItem = GalleryItem::query()->create([
        'caption_fr' => 'Reception',
        'caption_en' => 'Reception',
        'agency_id' => $agency->id,
        'category' => GalleryCategory::Reception,
        'image_path' => 'gallery/reception.jpg',
        'sort_order' => 1,
    ]);
    $testimonial = Testimonial::query()->create([
        'customer_name' => 'Client satisfait',
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service rapide.',
        'message_en' => 'Fast service.',
        'rating' => 5,
        'sort_order' => 1,
    ]);
    $tariff = Tariff::query()->create([
        'category' => 'light',
        'vehicle_type_fr' => 'Vehicules legers',
        'vehicle_type_en' => 'Light vehicles',
        'price' => null,
        'sort_order' => 1,
    ]);
    $setting = Setting::query()->create([
        'key' => 'seo_defaults',
        'value' => ['title_fr' => 'GS AUTOBILAN'],
    ]);
    $staffUser = User::query()->create([
        'name' => 'Staff User',
        'email' => 'staff-'.str()->uuid().'@example.test',
        'password' => 'password',
    ]);

    return compact(
        'agency',
        'otherAgency',
        'service',
        'booking',
        'otherBooking',
        'documentReadiness',
        'otherDocumentReadiness',
        'contactMessage',
        'otherContactMessage',
        'unassignedContactMessage',
        'articleCategory',
        'article',
        'faq',
        'galleryItem',
        'testimonial',
        'tariff',
        'setting',
        'staffUser',
    );
}

function s045Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => $slug,
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

function s045Booking(Agency $agency, Service $service, string $reference, string $registration): Booking
{
    return Booking::query()->create([
        'reference' => $reference,
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => $registration,
        'vehicle_type' => 'Car',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'status' => BookingStatus::NewRequest,
    ]);
}
