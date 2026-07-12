<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('article_categories')->nullOnDelete();
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->text('summary_fr')->nullable();
            $table->text('summary_en')->nullable();
            $table->longText('content_fr');
            $table->longText('content_en');
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('meta_title_fr')->nullable();
            $table->string('meta_title_en')->nullable();
            $table->text('meta_description_fr')->nullable();
            $table->text('meta_description_en')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question_fr');
            $table->text('question_en');
            $table->text('answer_fr');
            $table->text('answer_en');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('caption_fr')->nullable();
            $table->string('caption_en')->nullable();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->string('category');
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('category');
            $table->index(['is_active', 'sort_order']);
        });

        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_type_fr')->nullable();
            $table->string('customer_type_en')->nullable();
            $table->text('message_fr');
            $table->text('message_en');
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('article_categories');
    }
};
