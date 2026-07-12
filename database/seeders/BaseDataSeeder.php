<?php

namespace Database\Seeders;

use App\Models\Agency;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class BaseDataSeeder extends Seeder
{
    /**
     * Seed the application's base operational data.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->seedRoles();
        $this->seedSuperAdmin();
        $this->seedAgencies();
        $this->seedSettings();
        $this->seedServices();
        $this->seedTariffs();
        $this->seedFaqs();
        $this->seedArticleCategories();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    private function seedRoles(): void
    {
        foreach (['super_admin', 'agency_admin', 'content_manager'] as $role) {
            Role::findOrCreate($role, 'web');
        }
    }

    private function seedSuperAdmin(): void
    {
        $email = env('GS_SUPER_ADMIN_EMAIL', 'admin@gsautobilan.local');
        $password = env('GS_SUPER_ADMIN_PASSWORD');

        $user = User::where('email', $email)->first();

        if (! $user && filled($password)) {
            $user = User::create([
                'name' => env('GS_SUPER_ADMIN_NAME', 'GS AUTOBILAN Admin'),
                'email' => $email,
                'password' => Hash::make($password),
                'is_active' => true,
            ]);
        }

        $user?->assignRole('super_admin');
    }

    private function seedAgencies(): void
    {
        $agencies = [
            [
                'slug' => 'nkolbisson',
                'name_fr' => 'GS AUTOBILAN Agence de Nkolbisson',
                'name_en' => 'GS AUTOBILAN Nkolbisson Agency',
                'address_fr' => 'Carrefour Onana, a cote de la station Ajaxx, venant de Dagobert',
                'address_en' => 'Carrefour Onana, next to Ajaxx station, coming from Dagobert',
                'city' => 'Yaounde',
                'quarter' => 'Nkolbisson',
                'phones' => ['+237678844791', '+237652516527'],
                'whatsapp' => '+237678844791',
                'email' => 'gsautosbilan@gmail.com',
                'opening_hours_fr' => [
                    'monday_saturday' => '07h00-18h00',
                    'public_holidays' => 'Ouvert',
                ],
                'opening_hours_en' => [
                    'monday_saturday' => '07:00-18:00',
                    'public_holidays' => 'Open',
                ],
                'latitude' => 3.8882487,
                'longitude' => 11.4549352,
                'map_link' => 'https://www.google.com/maps?q=3.8882487,11.4549352',
                'status' => 'operational',
                'sort_order' => 1,
                'description_fr' => 'Agence GS AUTOBILAN de Nkolbisson pour la visite technique automobile.',
                'description_en' => 'GS AUTOBILAN Nkolbisson agency for vehicle technical inspection.',
                'is_active' => true,
            ],
            [
                'slug' => 'obili-scalom',
                'name_fr' => 'GS AUTOBILAN Agence de Obili Scalom',
                'name_en' => 'GS AUTOBILAN Obili Scalom Agency',
                'address_fr' => 'Obili Scalom',
                'address_en' => 'Obili Scalom',
                'city' => 'Yaounde',
                'quarter' => 'Obili Scalom',
                'phones' => ['+237678844791', '+237658473182'],
                'whatsapp' => '+237678844791',
                'email' => 'gsautosbilan@gmail.com',
                'opening_hours_fr' => [
                    'monday_saturday' => '07h00-19h00',
                    'sunday' => '07h00-15h00',
                    'public_holidays' => 'Ouvert',
                ],
                'opening_hours_en' => [
                    'monday_saturday' => '07:00-19:00',
                    'sunday' => '07:00-15:00',
                    'public_holidays' => 'Open',
                ],
                'latitude' => 3.8471748,
                'longitude' => 11.4967492,
                'map_link' => 'https://www.google.com/maps?q=3.8471748,11.4967492',
                'status' => 'operational',
                'sort_order' => 2,
                'description_fr' => 'Agence GS AUTOBILAN de Obili Scalom pour la visite technique automobile.',
                'description_en' => 'GS AUTOBILAN Obili Scalom agency for vehicle technical inspection.',
                'is_active' => true,
            ],
        ];

        foreach ($agencies as $agency) {
            Agency::updateOrCreate(
                ['slug' => $agency['slug']],
                $agency,
            );
        }
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_identity' => [
                'name' => 'GS AUTOBILAN',
                'slogan_fr' => "Votre securite, c'est notre metier.",
                'slogan_en' => 'Your safety is our profession.',
                'default_locale' => 'fr',
                'available_locales' => ['fr', 'en'],
            ],
            'direction_generale' => [
                'address_fr' => 'Bastos, derriere Hotel Le Diplomate',
                'address_en' => 'Bastos, behind Hotel Le Diplomate',
                'box_fr' => 'BP 12525',
                'box_en' => 'P.O. Box 12525',
                'phone' => '+237653283107',
                'email' => 'gsautosbilan@gmail.com',
            ],
            'seo_defaults' => [
                'title_fr' => 'GS AUTOBILAN - Centre de visite technique automobile',
                'title_en' => 'GS AUTOBILAN - Vehicle technical inspection centre',
                'description_fr' => 'GS AUTOBILAN accompagne les automobilistes a Yaounde pour la visite technique, la reservation et le suivi de rendez-vous.',
                'description_en' => 'GS AUTOBILAN supports drivers in Yaounde with vehicle inspection, booking, and appointment tracking.',
            ],
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'slug_fr' => 'vehicules-legers',
                'slug_en' => 'light-vehicles',
                'title_fr' => 'Vehicules legers',
                'title_en' => 'Light vehicles',
                'short_description_fr' => 'Visite technique pour voitures particulieres et vehicules personnels.',
                'short_description_en' => 'Technical inspection for passenger cars and personal vehicles.',
                'icon' => 'truck',
            ],
            [
                'slug_fr' => 'vehicules-utilitaires',
                'slug_en' => 'utility-vehicles',
                'title_fr' => 'Vehicules utilitaires',
                'title_en' => 'Utility vehicles',
                'short_description_fr' => 'Controle technique pour vehicules utilitaires et professionnels.',
                'short_description_en' => 'Technical inspection for utility and professional vehicles.',
                'icon' => 'truck',
            ],
            [
                'slug_fr' => 'taxis',
                'slug_en' => 'taxis',
                'title_fr' => 'Taxis',
                'title_en' => 'Taxis',
                'short_description_fr' => 'Accompagnement des taxis pour leurs obligations de visite technique.',
                'short_description_en' => 'Support for taxis with technical inspection requirements.',
                'icon' => 'truck',
            ],
            [
                'slug_fr' => 'auto-ecoles',
                'slug_en' => 'driving-schools',
                'title_fr' => 'Auto-ecoles',
                'title_en' => 'Driving schools',
                'short_description_fr' => 'Services de visite technique pour vehicules d auto-ecoles.',
                'short_description_en' => 'Inspection services for driving-school vehicles.',
                'icon' => 'academic-cap',
            ],
            [
                'slug_fr' => 'bus-transport-public',
                'slug_en' => 'buses-public-transport',
                'title_fr' => 'Bus & transport public',
                'title_en' => 'Buses & public transport',
                'short_description_fr' => 'Controle technique pour bus et vehicules de transport public.',
                'short_description_en' => 'Technical inspection for buses and public transport vehicles.',
                'icon' => 'truck',
            ],
            [
                'slug_fr' => 'poids-lourds',
                'slug_en' => 'heavy-goods-vehicles',
                'title_fr' => 'Poids lourds',
                'title_en' => 'Heavy goods vehicles',
                'short_description_fr' => 'Visite technique pour camions et vehicules lourds.',
                'short_description_en' => 'Technical inspection for trucks and heavy vehicles.',
                'icon' => 'truck',
            ],
            [
                'slug_fr' => 'contre-visite',
                'slug_en' => 're-inspection',
                'title_fr' => 'Contre-visite',
                'title_en' => 'Re-inspection',
                'short_description_fr' => 'Suivi apres correction des points signales lors de la visite.',
                'short_description_en' => 'Follow-up after correcting points raised during inspection.',
                'icon' => 'arrow-path',
            ],
            [
                'slug_fr' => 'entreprises-parcs-automobiles',
                'slug_en' => 'companies-vehicle-fleets',
                'title_fr' => 'Entreprises & parcs automobiles',
                'title_en' => 'Companies & vehicle fleets',
                'short_description_fr' => 'Organisation des visites pour entreprises et parcs automobiles.',
                'short_description_en' => 'Inspection coordination for companies and vehicle fleets.',
                'icon' => 'building-office-2',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['slug_fr' => $service['slug_fr']],
                $service + [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedTariffs(): void
    {
        $tariffs = [
            ['light', 'Vehicules legers', 'Light vehicles'],
            ['utility', 'Vehicules utilitaires', 'Utility vehicles'],
            ['taxi', 'Taxis', 'Taxis'],
            ['driving_school', 'Auto-ecoles', 'Driving schools'],
            ['public_transport', 'Bus & transport public', 'Buses & public transport'],
            ['heavy_goods', 'Poids lourds', 'Heavy goods vehicles'],
            ['reinspection', 'Contre-visite', 'Re-inspection'],
            ['fleet', 'Entreprises & parcs automobiles', 'Companies & vehicle fleets'],
        ];

        foreach ($tariffs as $index => [$category, $vehicleTypeFr, $vehicleTypeEn]) {
            Tariff::updateOrCreate(
                ['category' => $category],
                [
                    'vehicle_type_fr' => $vehicleTypeFr,
                    'vehicle_type_en' => $vehicleTypeEn,
                    'price' => null,
                    'currency' => 'XAF',
                    'validity' => null,
                    'notes_fr' => 'Tarif officiel en attente de confirmation.',
                    'notes_en' => 'Official tariff pending confirmation.',
                    'sort_order' => $index + 1,
                    'is_active' => true,
                    'is_placeholder' => true,
                    'last_updated_at' => null,
                ],
            );
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            [
                'question_fr' => 'La demande de rendez-vous confirme-t-elle automatiquement mon passage ?',
                'question_en' => 'Does a booking request automatically confirm my appointment?',
                'answer_fr' => 'Non. Votre demande est enregistree, puis notre equipe vous contacte par telephone ou WhatsApp pour confirmer la disponibilite.',
                'answer_en' => 'No. Your request is recorded, then our team contacts you by phone or WhatsApp to confirm availability.',
            ],
            [
                'question_fr' => 'Comment suivre mon rendez-vous ?',
                'question_en' => 'How can I track my appointment?',
                'answer_fr' => 'Utilisez votre reference, votre numero de telephone et l immatriculation du vehicule sur la page de suivi.',
                'answer_en' => 'Use your reference, phone number, and vehicle registration on the tracking page.',
            ],
            [
                'question_fr' => 'GS AUTOBILAN est-il ouvert les jours feries ?',
                'question_en' => 'Is GS AUTOBILAN open on public holidays?',
                'answer_fr' => 'Oui, les agences indiquees sont ouvertes les jours feries selon les informations confirmees.',
                'answer_en' => 'Yes, the listed agencies are open on public holidays according to the confirmed information.',
            ],
            [
                'question_fr' => 'Ou se trouvent les agences GS AUTOBILAN ?',
                'question_en' => 'Where are GS AUTOBILAN agencies located?',
                'answer_fr' => 'Les agences operationnelles sont a Nkolbisson et Obili Scalom, a Yaounde.',
                'answer_en' => 'The operational agencies are in Nkolbisson and Obili Scalom, Yaounde.',
            ],
            [
                'question_fr' => 'Les tarifs sont-ils deja officiels sur le site ?',
                'question_en' => 'Are the tariffs already official on the site?',
                'answer_fr' => 'Non. Les lignes de tarifs sont des emplacements provisoires jusqu a reception de la grille officielle.',
                'answer_en' => 'No. Tariff rows are placeholders until the official tariff table is received.',
            ],
            [
                'question_fr' => 'Puis-je contacter GS AUTOBILAN par WhatsApp ?',
                'question_en' => 'Can I contact GS AUTOBILAN on WhatsApp?',
                'answer_fr' => 'Oui, le site propose un lien WhatsApp pour joindre rapidement l equipe.',
                'answer_en' => 'Yes, the site provides a WhatsApp link to reach the team quickly.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::updateOrCreate(
                ['question_fr' => $faq['question_fr']],
                $faq + [
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedArticleCategories(): void
    {
        $categories = [
            ['maintenance', 'Entretien', 'Maintenance'],
            ['inspection', 'Visite technique', 'Inspection'],
            ['road-safety', 'Securite routiere', 'Road safety'],
            ['news', 'Actualites', 'News'],
            ['advice', 'Conseils', 'Advice'],
        ];

        foreach ($categories as $index => [$slug, $nameFr, $nameEn]) {
            ArticleCategory::updateOrCreate(
                ['slug_fr' => $slug],
                [
                    'name_fr' => $nameFr,
                    'name_en' => $nameEn,
                    'slug_en' => $slug,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ],
            );
        }
    }
}
