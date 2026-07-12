<?php

use App\Enums\ArticleStatus;
use App\Enums\ContactStatus;
use App\Filament\Resources\ArticleResource;
use App\Filament\Resources\ArticleResource\Pages\CreateArticle;
use App\Filament\Resources\ArticleResource\Pages\EditArticle;
use App\Filament\Resources\ArticleResource\Pages\ListArticles;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\ContactMessageResource\Pages\CreateContactMessage;
use App\Filament\Resources\ContactMessageResource\Pages\EditContactMessage;
use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Filament\Resources\FaqResource;
use App\Filament\Resources\FaqResource\Pages\CreateFaq;
use App\Filament\Resources\FaqResource\Pages\EditFaq;
use App\Filament\Resources\FaqResource\Pages\ListFaqs;
use App\Models\Agency;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

it('registers the S054 contact, article, and FAQ resources on the admin panel', function () {
    expect(Filament::getPanel('admin')->getResources())
        ->toContain(
            ContactMessageResource::class,
            ArticleResource::class,
            FaqResource::class,
        );
});

it('allows super admins to create, update, and delete contact messages', function () {
    $agency = s054Agency('nkolbisson', 1);
    $superAdmin = s054User('super_admin');

    s054ActingAs($superAdmin);

    Livewire::test(CreateContactMessage::class)
        ->fillForm(s054ContactPayload($agency))
        ->call('create')
        ->assertHasNoFormErrors();

    $message = ContactMessage::query()->where('subject', 'Demande S054')->firstOrFail();

    expect($message)
        ->status->toBe(ContactStatus::New)
        ->agency_id->toBe($agency->id);

    Livewire::test(ListContactMessages::class)
        ->assertCanSeeTableRecords([$message])
        ->assertTableColumnFormattedStateSet('status', 'New', $message);

    Livewire::test(EditContactMessage::class, ['record' => $message->id])
        ->fillForm([
            'status' => ContactStatus::Responded->value,
            'assigned_user_id' => $superAdmin->id,
            'internal_notes' => 'Client rappele.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($message->fresh())
        ->status->toBe(ContactStatus::Responded)
        ->assigned_user_id->toBe($superAdmin->id)
        ->internal_notes->toBe('Client rappele.');

    Livewire::test(EditContactMessage::class, ['record' => $message->id])
        ->callAction(DeleteAction::class);

    expect(ContactMessage::query()->whereKey($message->id)->exists())->toBeFalse();
});

it('scopes agency admins to their assigned contact messages', function () {
    $agency = s054Agency('nkolbisson', 1);
    $otherAgency = s054Agency('obili-scalom', 2);
    $message = s054ContactMessage($agency, 'Demande Nkolbisson');
    $otherMessage = s054ContactMessage($otherAgency, 'Demande Obili');
    $unassignedMessage = ContactMessage::query()->create([
        ...s054ContactPayload(null),
        'subject' => 'Demande non assignee',
    ]);

    s054ActingAs(s054User('agency_admin', $agency));

    $this->get('/admin/contact-messages')->assertOk();
    $this->get('/admin/contact-messages/create')->assertForbidden();
    $this->get("/admin/contact-messages/{$message->id}/edit")->assertOk();
    $this->get("/admin/contact-messages/{$otherMessage->id}/edit")->assertNotFound();
    $this->get("/admin/contact-messages/{$unassignedMessage->id}/edit")->assertNotFound();

    expect(ContactMessageResource::getEloquentQuery()->pluck('id')->all())
        ->toBe([$message->id])
        ->not->toContain($otherMessage->id, $unassignedMessage->id);

    Livewire::test(ListContactMessages::class)
        ->assertCanSeeTableRecords([$message])
        ->assertCanNotSeeTableRecords([$otherMessage, $unassignedMessage]);

    Livewire::test(EditContactMessage::class, ['record' => $message->id])
        ->fillForm([
            'status' => ContactStatus::InReview->value,
            'internal_notes' => 'Pris en charge par agence.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($message->fresh())
        ->status->toBe(ContactStatus::InReview)
        ->agency_id->toBe($agency->id)
        ->internal_notes->toBe('Pris en charge par agence.');
});

it('allows content managers to create, update, and delete articles', function () {
    $category = s054ArticleCategory('conseils');

    s054ActingAs(s054User('content_manager'));

    Livewire::test(CreateArticle::class)
        ->fillForm(s054ArticlePayload($category, 'preparer-sa-visite'))
        ->call('create')
        ->assertHasNoFormErrors();

    $article = Article::query()->where('slug_fr', 'preparer-sa-visite')->firstOrFail();

    expect($article)
        ->status->toBe(ArticleStatus::Draft)
        ->category_id->toBe($category->id);

    Livewire::test(ListArticles::class)
        ->assertCanSeeTableRecords([$article])
        ->assertTableColumnFormattedStateSet('status', 'Draft', $article);

    Livewire::test(EditArticle::class, ['record' => $article->id])
        ->fillForm([
            'status' => ArticleStatus::Published->value,
            'published_at' => '2026-07-12 10:30:00',
            'meta_title_fr' => 'Preparer sa visite technique',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($article->fresh())
        ->status->toBe(ArticleStatus::Published)
        ->meta_title_fr->toBe('Preparer sa visite technique');

    Livewire::test(EditArticle::class, ['record' => $article->id])
        ->callAction(DeleteAction::class);

    expect(Article::query()->whereKey($article->id)->exists())->toBeFalse();
});

it('allows content managers to create, update, and delete FAQs', function () {
    s054ActingAs(s054User('content_manager'));

    Livewire::test(CreateFaq::class)
        ->fillForm(s054FaqPayload('documents'))
        ->call('create')
        ->assertHasNoFormErrors();

    $faq = Faq::query()->where('question_fr', 'Quels documents documents ?')->firstOrFail();

    expect($faq)
        ->is_active->toBeTrue()
        ->sort_order->toBe(2);

    Livewire::test(ListFaqs::class)
        ->assertCanSeeTableRecords([$faq]);

    Livewire::test(EditFaq::class, ['record' => $faq->id])
        ->fillForm([
            'answer_fr' => 'Carte grise et CNI a jour.',
            'is_active' => false,
            'sort_order' => 5,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($faq->fresh())
        ->answer_fr->toBe('Carte grise et CNI a jour.')
        ->is_active->toBeFalse()
        ->sort_order->toBe(5);

    Livewire::test(EditFaq::class, ['record' => $faq->id])
        ->callAction(DeleteAction::class);

    expect(Faq::query()->whereKey($faq->id)->exists())->toBeFalse();
});

it('keeps content resources unavailable to agency admins and contact messages unavailable to content managers', function () {
    s054ActingAs(s054User('agency_admin', s054Agency('nkolbisson', 1)));

    expect(ArticleResource::canAccess())->toBeFalse();
    expect(FaqResource::canAccess())->toBeFalse();

    $this->get('/admin/articles')->assertForbidden();
    $this->get('/admin/faqs')->assertForbidden();

    s054ActingAs(s054User('content_manager'));

    expect(ContactMessageResource::canAccess())->toBeFalse();

    $this->get('/admin/contact-messages')->assertForbidden();
});

function s054ActingAs(User $user): void
{
    $panel = Filament::getPanel('admin');

    Filament::setCurrentPanel($panel);
    Filament::auth()->login($user);
    test()->actingAs($user);
}

function s054User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}

function s054Agency(string $slug, int $sortOrder): Agency
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

/**
 * @return array<string, mixed>
 */
function s054ContactPayload(?Agency $agency): array
{
    return [
        'name' => 'Client Contact S054',
        'phone' => '+237677054000',
        'email' => 'contact-s054@example.test',
        'agency_id' => $agency?->id,
        'subject' => 'Demande S054',
        'message' => 'Je voudrais des informations sur la visite technique.',
        'status' => ContactStatus::New->value,
        'assigned_user_id' => null,
        'internal_notes' => null,
    ];
}

function s054ContactMessage(Agency $agency, string $subject): ContactMessage
{
    return ContactMessage::query()->create([
        ...s054ContactPayload($agency),
        'subject' => $subject,
    ]);
}

function s054ArticleCategory(string $slug): ArticleCategory
{
    return ArticleCategory::query()->create([
        'name_fr' => 'Conseils '.$slug,
        'name_en' => 'Advice '.$slug,
        'slug_fr' => 'conseils-'.$slug,
        'slug_en' => 'advice-'.$slug,
        'sort_order' => 1,
        'is_active' => true,
    ]);
}

/**
 * @return array<string, mixed>
 */
function s054ArticlePayload(ArticleCategory $category, string $slug): array
{
    return [
        'category_id' => $category->id,
        'status' => ArticleStatus::Draft->value,
        'title_fr' => 'Preparer sa visite',
        'title_en' => 'Prepare your visit',
        'slug_fr' => $slug,
        'slug_en' => 'prepare-your-visit-'.$slug,
        'summary_fr' => 'Resume FR.',
        'summary_en' => 'EN summary.',
        'content_fr' => 'Contenu long FR.',
        'content_en' => 'Long EN content.',
        'featured_image' => null,
        'published_at' => null,
        'meta_title_fr' => null,
        'meta_title_en' => null,
        'meta_description_fr' => null,
        'meta_description_en' => null,
    ];
}

/**
 * @return array<string, mixed>
 */
function s054FaqPayload(string $suffix): array
{
    return [
        'question_fr' => 'Quels documents '.$suffix.' ?',
        'question_en' => 'Which documents '.$suffix.'?',
        'answer_fr' => 'Carte grise, assurance et CNI.',
        'answer_en' => 'Registration card, insurance, and ID.',
        'sort_order' => 2,
        'is_active' => true,
    ];
}
