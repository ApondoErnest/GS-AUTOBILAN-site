<?php

namespace App\Services;

use App\Data\TrackingResult;
use App\Models\Booking;
use Illuminate\Support\Str;

class TrackingService
{
    public function lookup(string $reference, string $phone, string $vehicleRegistration): ?TrackingResult
    {
        $reference = $this->normalizeReference($reference);
        $phone = $this->normalizePhone($phone);
        $vehicleRegistration = $this->normalizeVehicleRegistration($vehicleRegistration);

        if ($reference === '' || $phone === '' || $vehicleRegistration === '') {
            return null;
        }

        $booking = Booking::query()
            ->with(['agency', 'documentReadiness'])
            ->where('reference', $reference)
            ->first();

        if (! $booking) {
            return null;
        }

        if ($this->normalizePhone($booking->phone) !== $phone) {
            return null;
        }

        if ($this->normalizeVehicleRegistration($booking->vehicle_registration) !== $vehicleRegistration) {
            return null;
        }

        return TrackingResult::fromBooking($booking);
    }

    private function normalizeReference(string $reference): string
    {
        return preg_replace('/\s+/', '', Str::upper($reference)) ?? '';
    }

    private function normalizePhone(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone) ?? '';
    }

    private function normalizeVehicleRegistration(string $vehicleRegistration): string
    {
        return preg_replace('/\s+/', '', Str::upper($vehicleRegistration)) ?? '';
    }
}
