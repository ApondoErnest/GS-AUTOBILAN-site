<?php

namespace App\Services;

use App\Enums\DocumentReadinessStatus;
use App\Models\Booking;
use App\Models\DocumentReadiness;

class DocumentReadinessService
{
    /**
     * Ensure a booking has the default document-readiness record.
     */
    public function createDefaultFor(Booking $booking): DocumentReadiness
    {
        return DocumentReadiness::query()->firstOrCreate(
            ['booking_id' => $booking->id],
            ['status' => DocumentReadinessStatus::NotReviewed],
        );
    }
}
