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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->string('name_fr');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->text('address_fr');
            $table->text('address_en');
            $table->string('city')->nullable();
            $table->string('quarter')->nullable();
            $table->json('phones');
            $table->string('whatsapp')->nullable();
            $table->string('email');
            $table->json('opening_hours_fr');
            $table->json('opening_hours_en');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('map_link')->nullable();
            $table->string('status')->default('operational');
            $table->unsignedInteger('sort_order')->default(0);
            $table->text('description_fr')->nullable();
            $table->text('description_en')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
            $table->index('status');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('value');
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr');
            $table->string('title_en');
            $table->string('slug_fr')->unique();
            $table->string('slug_en')->unique();
            $table->text('short_description_fr');
            $table->text('short_description_en');
            $table->text('full_description_fr')->nullable();
            $table->text('full_description_en')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('assigned_agency_id')
                ->nullable()
                ->constrained('agencies')
                ->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('assigned_agency_id');
            $table->dropColumn(['is_active', 'last_login_at']);
        });

        Schema::dropIfExists('services');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('agencies');
    }
};
