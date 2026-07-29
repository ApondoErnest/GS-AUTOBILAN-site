<?php

use App\Enums\ArticleStatus;
use App\Enums\GalleryCategory;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\GalleryItem;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function () {
    app()->setLocale('en');
    app(PermissionRegistrar::class)->forgetCachedPermissions();

    foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
        Role::findOrCreate($role, 'web');
    }
});

afterEach(function () {
    app()->setLocale('en');
});

it('renders the website content section with compact publishing data in English', function () {
    s096ContentData();
    $contentManager = s096User('content_manager');

    $this
        ->actingAs($contentManager)
        ->get('/admin/website-content?locale=en')
        ->assertOk()
        ->assertSee('Website Content')
        ->assertSee('Website publishing control')
        ->assertSee('Content workspaces')
        ->assertSee('Publishing workload')
        ->assertSee('Latest articles')
        ->assertSee('Prepare your visit')
        ->assertSee('Draft articles');
});

it('renders the website content section in French', function () {
    s096ContentData();
    $superAdmin = s096User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/website-content?locale=fr')
        ->assertOk()
        ->assertSee('Contenu du site')
        ->assertSee('Pilotage éditorial du site')
        ->assertSee('Espaces contenu')
        ->assertSee('Charge de publication')
        ->assertSee('Derniers articles')
        ->assertSee('Préparer sa visite')
        ->assertSee('Articles brouillons');
});

it('keeps the website content section unavailable to agency admins', function () {
    s096ContentData();
    $agencyAdmin = s096User('agency_admin');

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/website-content?locale=en')
        ->assertForbidden();
});

function s096ContentData(): void
{
    $category = ArticleCategory::query()->create([
        'name_fr' => 'Conseils pratiques',
        'name_en' => 'Practical advice',
        'slug_fr' => 'conseils-pratiques-s092',
        'slug_en' => 'practical-advice-s092',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Préparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => 'preparer-sa-visite-s092',
        'slug_en' => 'prepare-your-visit-s092',
        'summary_fr' => 'Les étapes utiles avant le contrôle.',
        'summary_en' => 'Useful steps before inspection.',
        'content_fr' => 'Un contenu complet pour préparer la visite technique.',
        'content_en' => 'Complete content to prepare the technical inspection.',
        'status' => ArticleStatus::Published->value,
        'published_at' => now()->subDay(),
    ]);

    Article::query()->create([
        'category_id' => $category->id,
        'title_fr' => 'Documents à vérifier',
        'title_en' => 'Documents to check',
        'slug_fr' => 'documents-a-verifier-s092',
        'slug_en' => 'documents-to-check-s092',
        'summary_fr' => 'Brouillon documentaire.',
        'summary_en' => 'Document draft.',
        'content_fr' => 'Brouillon en attente de validation.',
        'content_en' => 'Draft awaiting validation.',
        'status' => ArticleStatus::Draft->value,
        'published_at' => null,
    ]);

    Faq::query()->create([
        'question_fr' => 'Quels documents apporter ?',
        'question_en' => 'Which documents should I bring?',
        'answer_fr' => 'Carte grise, assurance et CNI.',
        'answer_en' => 'Registration card, insurance, and ID.',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    Faq::query()->create([
        'question_fr' => 'Question masquée ?',
        'question_en' => 'Hidden question?',
        'answer_fr' => 'Réponse masquée.',
        'answer_en' => 'Hidden answer.',
        'sort_order' => 2,
        'is_active' => false,
    ]);

    GalleryItem::query()->create([
        'caption_fr' => 'Réception propre',
        'caption_en' => 'Clean reception',
        'category' => GalleryCategory::Reception->value,
        'image_path' => 'gallery/reception-s092.jpg',
        'sort_order' => 1,
        'is_active' => true,
    ]);

    Testimonial::query()->create([
        'customer_name' => 'Client S092',
        'customer_type_fr' => 'Particulier',
        'customer_type_en' => 'Individual',
        'message_fr' => 'Service professionnel.',
        'message_en' => 'Professional service.',
        'rating' => 5,
        'sort_order' => 1,
        'is_active' => false,
    ]);
}

function s096User(string $role): User
{
    $user = User::factory()->create();

    $user->assignRole($role);

    return $user->fresh();
}
