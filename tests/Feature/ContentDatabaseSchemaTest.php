<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates the S037 content tables and confirms activity logging is ready', function () {
    expect(Schema::hasColumns('article_categories', [
        'name_fr',
        'name_en',
        'slug_fr',
        'slug_en',
        'sort_order',
        'is_active',
    ]))->toBeTrue();

    expect(Schema::hasColumns('articles', [
        'category_id',
        'title_fr',
        'title_en',
        'slug_fr',
        'slug_en',
        'summary_fr',
        'summary_en',
        'content_fr',
        'content_en',
        'featured_image',
        'status',
        'published_at',
        'meta_title_fr',
        'meta_title_en',
        'meta_description_fr',
        'meta_description_en',
    ]))->toBeTrue();

    expect(Schema::hasColumns('faqs', [
        'question_fr',
        'question_en',
        'answer_fr',
        'answer_en',
        'sort_order',
        'is_active',
    ]))->toBeTrue();

    expect(Schema::hasColumns('gallery_items', [
        'caption_fr',
        'caption_en',
        'agency_id',
        'category',
        'image_path',
        'sort_order',
        'is_active',
    ]))->toBeTrue();

    expect(Schema::hasColumns('testimonials', [
        'customer_name',
        'customer_type_fr',
        'customer_type_en',
        'message_fr',
        'message_en',
        'rating',
        'image_path',
        'sort_order',
        'is_active',
    ]))->toBeTrue();

    expect(Schema::hasTable('activity_log'))->toBeTrue();
});
