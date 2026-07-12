<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates the S036 booking, tariff, document readiness, and contact tables', function () {
    expect(Schema::hasColumns('tariffs', [
        'category',
        'vehicle_type_fr',
        'vehicle_type_en',
        'price',
        'currency',
        'validity',
        'notes_fr',
        'notes_en',
        'sort_order',
        'is_active',
        'is_placeholder',
        'last_updated_at',
    ]))->toBeTrue();

    expect(Schema::hasColumns('bookings', [
        'reference',
        'customer_name',
        'phone',
        'whatsapp',
        'email',
        'agency_id',
        'service_id',
        'vehicle_registration',
        'vehicle_type',
        'vehicle_category',
        'vehicle_brand_model',
        'preferred_date',
        'preferred_time_slot',
        'confirmed_date',
        'confirmed_time_slot',
        'status',
        'customer_message',
        'internal_notes',
        'public_message',
    ]))->toBeTrue();

    expect(Schema::hasColumns('document_readiness', [
        'booking_id',
        'status',
        'missing_information_note',
        'next_action_fr',
        'next_action_en',
        'public_message_fr',
        'public_message_en',
        'updated_by',
    ]))->toBeTrue();

    expect(Schema::hasColumns('contact_messages', [
        'name',
        'phone',
        'email',
        'agency_id',
        'subject',
        'message',
        'status',
        'assigned_user_id',
        'internal_notes',
    ]))->toBeTrue();
});
