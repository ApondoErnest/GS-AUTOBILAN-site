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

uses(RefreshDatabase::class);

it('locks the V1 status and category enum values', function () {
    expect(array_column(BookingStatus::cases(), 'value'))->toBe([
        'new_request',
        'pending_confirmation',
        'confirmed',
        'rescheduled',
        'cancelled',
        'completed',
        'no_show',
    ]);

    expect(array_column(DocumentReadinessStatus::cases(), 'value'))->toBe([
        'not_reviewed',
        'complete',
        'missing_info',
        'contact_agency',
        'ready_for_visit',
    ]);

    expect(array_column(ContactStatus::cases(), 'value'))->toBe([
        'new',
        'in_review',
        'responded',
        'closed',
        'spam',
    ]);

    expect(array_column(ArticleStatus::cases(), 'value'))->toBe([
        'draft',
        'published',
        'archived',
    ]);

    expect(array_column(GalleryCategory::cases(), 'value'))->toBe([
        'agency_exterior',
        'reception',
        'inspection_lane',
        'staff',
        'equipment',
        'customer_area',
    ]);
});

it('casts core attributes and wires documented relationships', function () {
    $agency = Agency::create([
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

    $service = Service::create([
        'title_fr' => 'Vehicules legers',
        'title_en' => 'Light vehicles',
        'slug_fr' => 'vehicules-legers',
        'slug_en' => 'light-vehicles',
        'short_description_fr' => 'Controle technique pour voitures particulieres.',
        'short_description_en' => 'Technical inspection for passenger cars.',
        'sort_order' => 1,
    ]);

    $user = User::create([
        'name' => 'Agency Admin',
        'email' => 'agency-admin@example.test',
        'password' => 'password',
        'assigned_agency_id' => $agency->id,
    ]);

    $booking = Booking::create([
        'reference' => 'GS-2026-000001',
        'customer_name' => 'Client GS',
        'phone' => '+237699000000',
        'whatsapp' => '+237699000000',
        'email' => 'client@example.test',
        'agency_id' => $agency->id,
        'service_id' => $service->id,
        'vehicle_registration' => 'CE123AB',
        'vehicle_type' => 'Car',
        'vehicle_category' => 'light',
        'vehicle_brand_model' => 'Toyota Corolla',
        'preferred_date' => '2026-07-20',
        'preferred_time_slot' => '09h00-10h00',
        'status' => BookingStatus::Confirmed,
    ]);

    $documentReadiness = DocumentReadiness::create([
        'booking_id' => $booking->id,
        'status' => DocumentReadinessStatus::Complete,
        'next_action_fr' => 'Presentez-vous au centre.',
        'next_action_en' => 'Please come to the centre.',
        'updated_by' => $user->id,
    ]);

    $contactMessage = ContactMessage::create([
        'name' => 'Client Contact',
        'phone' => '+237677000000',
        'email' => 'contact@example.test',
        'agency_id' => $agency->id,
        'subject' => 'Renseignement',
        'message' => 'Je voudrais une information.',
        'status' => ContactStatus::InReview,
        'assigned_user_id' => $user->id,
    ]);

    $articleCategory = ArticleCategory::create([
        'name_fr' => 'Conseils',
        'name_en' => 'Tips',
        'slug_fr' => 'conseils',
        'slug_en' => 'tips',
        'sort_order' => 1,
    ]);

    $article = Article::create([
        'category_id' => $articleCategory->id,
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite',
        'slug_en' => 'prepare-your-visit',
        'summary_fr' => 'Les points a verifier.',
        'summary_en' => 'Things to check.',
        'content_fr' => 'Contenu FR.',
        'content_en' => 'EN content.',
        'status' => ArticleStatus::Published,
        'published_at' => now()->subDay(),
    ]);

    $faq = Faq::create([
        'question_fr' => 'La reservation est-elle automatique ?',
        'question_en' => 'Is booking automatic?',
        'answer_fr' => 'Non, notre equipe confirme.',
        'answer_en' => 'No, our team confirms it.',
        'sort_order' => 1,
    ]);

    $galleryItem = GalleryItem::create([
        'caption_fr' => 'Reception',
        'caption_en' => 'Reception',
        'agency_id' => $agency->id,
        'category' => GalleryCategory::Reception,
        'image_path' => 'gallery/reception.jpg',
        'sort_order' => 1,
    ]);

    $setting = Setting::create([
        'key' => 'seo_defaults',
        'value' => ['title' => 'GS AUTOBILAN'],
    ]);

    $tariff = Tariff::create([
        'category' => 'light',
        'vehicle_type_fr' => 'Vehicules legers',
        'vehicle_type_en' => 'Light vehicles',
        'price' => null,
        'sort_order' => 1,
    ]);

    $testimonial = Testimonial::create([
        'customer_name' => 'Client satisfait',
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service rapide.',
        'message_en' => 'Fast service.',
        'rating' => 5,
        'sort_order' => 1,
    ]);

    expect($agency->fresh()->phones)->toBe(['+237678844791']);
    expect($setting->fresh()->value)->toBe(['title' => 'GS AUTOBILAN']);
    expect($tariff->fresh()->is_placeholder)->toBeTrue();

    expect($booking->fresh()->status)->toBe(BookingStatus::Confirmed);
    expect($documentReadiness->fresh()->status)->toBe(DocumentReadinessStatus::Complete);
    expect($contactMessage->fresh()->status)->toBe(ContactStatus::InReview);
    expect($article->fresh()->status)->toBe(ArticleStatus::Published);
    expect($galleryItem->fresh()->category)->toBe(GalleryCategory::Reception);
    expect($testimonial->fresh()->rating)->toBe(5);

    expect($booking->fresh()->agency->is($agency))->toBeTrue();
    expect($booking->fresh()->service->is($service))->toBeTrue();
    expect($booking->fresh()->documentReadiness->is($documentReadiness))->toBeTrue();
    expect($documentReadiness->fresh()->updatedBy->is($user))->toBeTrue();
    expect($contactMessage->fresh()->agency->is($agency))->toBeTrue();
    expect($contactMessage->fresh()->assignedUser->is($user))->toBeTrue();
    expect($user->fresh()->assignedAgency->is($agency))->toBeTrue();
    expect($article->fresh()->category->is($articleCategory))->toBeTrue();
    expect($galleryItem->fresh()->agency->is($agency))->toBeTrue();

    expect(Agency::active()->ordered()->first()->is($agency))->toBeTrue();
    expect(Service::active()->ordered()->first()->is($service))->toBeTrue();
    expect(Article::published()->first()->is($article))->toBeTrue();
    expect(Faq::active()->ordered()->first()->is($faq))->toBeTrue();
    expect(GalleryItem::active()->ordered()->first()->is($galleryItem))->toBeTrue();
    expect(Testimonial::active()->ordered()->first()->is($testimonial))->toBeTrue();
});
