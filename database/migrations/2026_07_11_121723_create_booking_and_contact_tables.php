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
        Schema::create('tariffs', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('vehicle_type_fr');
            $table->string('vehicle_type_en');
            $table->decimal('price', 12, 2)->nullable();
            $table->string('currency', 3)->default('XAF');
            $table->string('validity')->nullable();
            $table->text('notes_fr')->nullable();
            $table->text('notes_en')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_placeholder')->default(true);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'is_placeholder', 'sort_order']);
            $table->index('category');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('customer_name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('agency_id')->constrained('agencies')->restrictOnDelete();
            $table->foreignId('service_id')->constrained('services')->restrictOnDelete();
            $table->string('vehicle_registration');
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_brand_model')->nullable();
            $table->date('preferred_date');
            $table->string('preferred_time_slot');
            $table->date('confirmed_date')->nullable();
            $table->string('confirmed_time_slot')->nullable();
            $table->string('status')->default('new_request');
            $table->text('customer_message')->nullable();
            $table->text('internal_notes')->nullable();
            $table->text('public_message')->nullable();
            $table->timestamps();

            $table->index('phone');
            $table->index('vehicle_registration');
            $table->index('status');
            $table->index('agency_id');
            $table->index('service_id');
            $table->index('preferred_date');
        });

        Schema::create('document_readiness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->cascadeOnDelete();
            $table->string('status')->default('not_reviewed');
            $table->text('missing_information_note')->nullable();
            $table->text('next_action_fr')->nullable();
            $table->text('next_action_en')->nullable();
            $table->text('public_message_fr')->nullable();
            $table->text('public_message_en')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('status');
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('agency_id')->nullable()->constrained('agencies')->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('new');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('internal_notes')->nullable();
            $table->timestamps();

            $table->index(['status', 'agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('document_readiness');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('tariffs');
    }
};
