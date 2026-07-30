<?php

use App\Enums\ContactStatus;
use App\Models\Agency;
use App\Models\ContactMessage;
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

it('renders the redesigned contact messages resource in English', function () {
    $data = s100ContactMessagesData();
    $superAdmin = s100User('super_admin');

    $this
        ->actingAs($superAdmin)
        ->get('/admin/contact-messages?locale=en')
        ->assertOk()
        ->assertSee('Message inbox')
        ->assertSee('Subject / message')
        ->assertSee('Sender')
        ->assertSee('Response status')
        ->assertSee('Demande S100 Nkolbisson')
        ->assertSee('New');

    $this
        ->actingAs($superAdmin)
        ->get("/admin/contact-messages/{$data['message']->id}/edit?locale=en")
        ->assertOk()
        ->assertSee('Sender and routing')
        ->assertSee('Customer request')
        ->assertSee('Handling notes');
});

it('renders the redesigned contact messages resource in French with agency scope', function () {
    $data = s100ContactMessagesData();
    $agencyAdmin = s100User('agency_admin', $data['agency']);

    $this
        ->actingAs($agencyAdmin)
        ->get('/admin/contact-messages?locale=fr')
        ->assertOk()
        ->assertSee('Boîte de réception')
        ->assertSee('Sujet / message')
        ->assertSee('Expéditeur')
        ->assertSee('État de réponse')
        ->assertSee('Demande S100 Nkolbisson')
        ->assertSee('Nouveau')
        ->assertDontSee('Demande S100 Obili');
});

/**
 * @return array{agency: Agency, otherAgency: Agency, message: ContactMessage, otherMessage: ContactMessage}
 */
function s100ContactMessagesData(): array
{
    $agency = s100Agency('nkolbisson', 1);
    $otherAgency = s100Agency('obili', 2);
    $message = s100ContactMessage($agency, 'Demande S100 Nkolbisson', ContactStatus::New);
    $otherMessage = s100ContactMessage($otherAgency, 'Demande S100 Obili', ContactStatus::Responded);

    return compact('agency', 'otherAgency', 'message', 'otherMessage');
}

function s100Agency(string $slug, int $sortOrder): Agency
{
    return Agency::query()->create([
        'name_fr' => 'GS AUTOBILAN '.str($slug)->headline(),
        'name_en' => 'GS AUTOBILAN '.str($slug)->headline(),
        'slug' => 's100-'.$slug,
        'address_fr' => 'Carrefour '.$slug,
        'address_en' => $slug.' junction',
        'city' => 'Yaounde',
        'quarter' => str($slug)->headline(),
        'phones' => ['+237678100001'],
        'whatsapp' => '+237678100001',
        'email' => 's100-'.$slug.'@example.test',
        'opening_hours_fr' => ['monday_saturday' => '07h00-18h00'],
        'opening_hours_en' => ['monday_saturday' => '07:00-18:00'],
        'latitude' => 3.8882487,
        'longitude' => 11.4549352,
        'status' => 'operational',
        'sort_order' => $sortOrder,
        'is_active' => true,
    ]);
}

function s100ContactMessage(Agency $agency, string $subject, ContactStatus $status): ContactMessage
{
    return ContactMessage::query()->create([
        'name' => 'Client S100',
        'phone' => '+237677100001',
        'email' => 'client-s100@example.test',
        'agency_id' => $agency->id,
        'subject' => $subject,
        'message' => 'Je voudrais des informations sur ma demande.',
        'status' => $status,
        'assigned_user_id' => null,
        'internal_notes' => null,
    ]);
}

function s100User(string $role, ?Agency $agency = null): User
{
    $user = User::factory()->create([
        'assigned_agency_id' => $agency?->id,
    ]);

    $user->assignRole($role);

    return $user->fresh();
}
