<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates the S035 core database tables and user fields', function () {
    expect(Schema::hasColumns('users', [
        'assigned_agency_id',
        'is_active',
        'last_login_at',
    ]))->toBeTrue();

    expect(Schema::hasColumns('agencies', [
        'name_fr',
        'name_en',
        'slug',
        'address_fr',
        'address_en',
        'phones',
        'opening_hours_fr',
        'opening_hours_en',
        'latitude',
        'longitude',
        'status',
        'sort_order',
        'is_active',
    ]))->toBeTrue();

    expect(Schema::hasColumns('settings', [
        'key',
        'value',
    ]))->toBeTrue();

    expect(Schema::hasColumns('services', [
        'title_fr',
        'title_en',
        'slug_fr',
        'slug_en',
        'short_description_fr',
        'short_description_en',
        'sort_order',
        'is_active',
    ]))->toBeTrue();
});
