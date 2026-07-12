<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Events\BookingCreated;
use App\Models\Booking;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        private readonly BookingReferenceService $references,
        private readonly DocumentReadinessService $documentReadiness,
    ) {}

    /**
     * Create a booking request and its default document-readiness record.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function create(array $attributes): Booking
    {
        $booking = DB::transaction(function () use ($attributes): Booking {
            $booking = Booking::query()->create([
                ...Arr::only($attributes, [
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
                    'customer_message',
                ]),
                'reference' => $this->references->generate(),
                'status' => BookingStatus::NewRequest,
            ]);

            $this->documentReadiness->createDefaultFor($booking);

            return $booking->load('documentReadiness');
        });

        BookingCreated::dispatch($booking);

        return $booking;
    }
}
