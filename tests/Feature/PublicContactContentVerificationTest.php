<?php

use App\Models\Agency;
use App\Models\Setting;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;

uses(RefreshDatabase::class);

it('keeps S085 public contact translation sources aligned with confirmed company data', function () {
    $frenchCopy = s085TranslationCopy('fr', [
        'about',
        'agencies',
        'booking',
        'chrome',
        'contact',
        'footer',
        'home',
    ]);
    $englishCopy = s085TranslationCopy('en', [
        'about',
        'agencies',
        'booking',
        'chrome',
        'contact',
        'footer',
        'home',
    ]);

    expect(require lang_path('fr/chrome.php'))
        ->slogan->toBe('Votre sécurité, c’est notre métier.');
    expect(require lang_path('en/chrome.php'))
        ->slogan->toBe('Your safety is our profession.');

    expect($frenchCopy)
        ->toContain('Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert')
        ->toContain('Obili Scalom')
        ->toContain('Bastos, derrière Hôtel Le Diplomate')
        ->toContain('BP 12525')
        ->toContain('+237 678 844 791 / +237 652 516 527')
        ->toContain('+237 678 844 791 / +237 658 473 182')
        ->toContain('+237 653 283 107')
        ->toContain('gsautosbilan@gmail.com')
        ->toContain('admin@gsautobilan.com')
        ->toContain('dimanche 07h00–15h00')
        ->toContain('Dimanche : 07h00 – 15h00')
        ->not->toContain('nkolbisson@gsautobilan.cm')
        ->not->toContain('obili@gsautobilan.cm')
        ->not->toContain('direction@gsautobilan.cm')
        ->not->toContain('+237 222 220 682')
        ->not->toContain('+237 695 300 400')
        ->not->toContain('/ 652 516 527')
        ->not->toContain('/ 658 473 182');

    expect($englishCopy)
        ->toContain('Carrefour Onana, next to Ajaxx station, coming from Dagobert')
        ->toContain('Obili Scalom')
        ->toContain('Bastos, behind Hotel Le Diplomate')
        ->toContain('P.O. Box 12525')
        ->toContain('+237 678 844 791 / +237 652 516 527')
        ->toContain('+237 678 844 791 / +237 658 473 182')
        ->toContain('+237 653 283 107')
        ->toContain('gsautosbilan@gmail.com')
        ->toContain('admin@gsautobilan.com')
        ->toContain('Sunday 07:00–15:00')
        ->toContain('Sunday: 07:00 – 15:00')
        ->not->toContain('nkolbisson@gsautobilan.cm')
        ->not->toContain('obili@gsautobilan.cm')
        ->not->toContain('direction@gsautobilan.cm')
        ->not->toContain('+237 222 220 682')
        ->not->toContain('+237 695 300 400')
        ->not->toContain('/ 652 516 527')
        ->not->toContain('/ 658 473 182');
});

it('renders S085 confirmed contact content on the public contact page', function (string $path, array $expected) {
    $response = $this->get($path);

    $response->assertOk();

    foreach ($expected as $copy) {
        $response->assertSee($copy, false);
    }

    $response
        ->assertDontSee('nkolbisson@gsautobilan.cm', false)
        ->assertDontSee('obili@gsautobilan.cm', false)
        ->assertDontSee('direction@gsautobilan.cm', false)
        ->assertDontSee('+237 222 220 682', false)
        ->assertDontSee('+237 695 300 400', false);
})->with([
    'French contact page' => ['/fr/contact', [
        'Votre sécurité, c’est notre métier.',
        'Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert',
        'Lundi à Samedi : 07h00 – 18h00',
        'Lundi à Samedi : 07h00 – 19h00',
        'Dimanche : 07h00 – 15h00',
        '+237 678 844 791 / +237 652 516 527',
        '+237 678 844 791 / +237 658 473 182',
        'Bastos, derrière Hôtel Le Diplomate',
        'BP 12525',
        '+237 653 283 107',
        'gsautosbilan@gmail.com',
        'admin@gsautobilan.com',
    ]],
    'English contact page' => ['/en/contact', [
        'Your safety is our profession.',
        'Carrefour Onana, next to Ajaxx station, coming from Dagobert',
        'Monday to Saturday: 07:00 – 18:00',
        'Monday to Saturday: 07:00 – 19:00',
        'Sunday: 07:00 – 15:00',
        '+237 678 844 791 / +237 652 516 527',
        '+237 678 844 791 / +237 658 473 182',
        'Bastos, behind Hotel Le Diplomate',
        'P.O. Box 12525',
        '+237 653 283 107',
        'gsautosbilan@gmail.com',
        'admin@gsautobilan.com',
    ]],
]);

it('seeds S085 company contact data from the confirmed source of truth', function () {
    $this->seed(DatabaseSeeder::class);

    $nkolbisson = Agency::query()->where('slug', 'nkolbisson')->firstOrFail();
    $obiliScalom = Agency::query()->where('slug', 'obili-scalom')->firstOrFail();
    $identity = Setting::query()->where('key', 'site_identity')->firstOrFail()->value;
    $headOffice = Setting::query()->where('key', 'direction_generale')->firstOrFail()->value;

    expect($nkolbisson)
        ->name_fr->toBe('GS AUTOBILAN Agence de Nkolbisson')
        ->address_fr->toBe('Carrefour Onana, à côté de la station Ajaxx, venant de Dagobert')
        ->phones->toBe(['+237678844791', '+237652516527'])
        ->email->toBe('gsautosbilan@gmail.com');
    expect($nkolbisson->opening_hours_fr)
        ->toMatchArray([
            'monday_saturday' => '07h00-18h00',
            'public_holidays' => 'Ouvert',
        ]);

    expect($obiliScalom)
        ->name_fr->toBe('GS AUTOBILAN Agence de Obili Scalom')
        ->address_fr->toBe('Obili Scalom')
        ->phones->toBe(['+237678844791', '+237658473182'])
        ->email->toBe('gsautosbilan@gmail.com');
    expect($obiliScalom->opening_hours_fr)
        ->toMatchArray([
            'monday_saturday' => '07h00-19h00',
            'sunday' => '07h00-15h00',
            'public_holidays' => 'Ouvert',
        ]);

    expect($identity)
        ->toMatchArray([
            'slogan_fr' => 'Votre sécurité, c’est notre métier.',
            'slogan_en' => 'Your safety is our profession.',
        ]);
    expect($headOffice)
        ->toMatchArray([
            'address_fr' => 'Bastos, derrière Hôtel Le Diplomate',
            'address_en' => 'Bastos, behind Hotel Le Diplomate',
            'box_fr' => 'BP 12525',
            'box_en' => 'P.O. Box 12525',
            'phone' => '+237653283107',
            'email' => 'gsautosbilan@gmail.com',
            'emails' => [
                'gsautosbilan@gmail.com',
                'admin@gsautobilan.com',
            ],
        ]);
});

/**
 * @param  array<int, string>  $files
 */
function s085TranslationCopy(string $locale, array $files): string
{
    return collect($files)
        ->flatMap(fn (string $file): array => Arr::dot(require lang_path($locale.'/'.$file.'.php')))
        ->filter(fn (mixed $value): bool => is_scalar($value))
        ->implode("\n");
}
