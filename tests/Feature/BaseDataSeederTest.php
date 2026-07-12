<?php

use App\Models\Agency;
use App\Models\ArticleCategory;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Tariff;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

it('seeds the S039 base data idempotently', function () {
    $admin = User::factory()->create([
        'email' => 'admin@gsautobilan.local',
    ]);

    $this->seed(DatabaseSeeder::class);
    $this->seed(DatabaseSeeder::class);

    expect(Role::query()->whereIn('name', [
        'super_admin',
        'agency_admin',
        'content_manager',
    ])->count())->toBe(3);

    expect($admin->fresh()->hasRole('super_admin'))->toBeTrue();

    expect(Agency::query()->count())->toBe(2);
    expect(Agency::query()->where('slug', 'nkolbisson')->first()->phones)
        ->toBe(['+237678844791', '+237652516527']);
    expect(Agency::query()->where('slug', 'obili-scalom')->first()->phones)
        ->toBe(['+237678844791', '+237658473182']);

    expect(Setting::query()->whereIn('key', [
        'site_identity',
        'direction_generale',
        'seo_defaults',
    ])->count())->toBe(3);

    expect(Service::query()->where('is_active', true)->count())->toBe(8);

    expect(Tariff::query()->count())->toBe(8);
    expect(Tariff::query()->where('is_placeholder', true)->count())->toBe(8);
    expect(Tariff::query()->whereNotNull('price')->count())->toBe(0);

    expect(Faq::query()->where('is_active', true)->count())->toBe(6);
    expect(ArticleCategory::query()->where('is_active', true)->count())->toBe(5);
});
