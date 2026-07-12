<?php

namespace App\Data;

use App\Enums\BookingStatus;
use App\Enums\DocumentReadinessStatus;
use App\Models\Booking;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
readonly class TrackingResult implements Arrayable
{
    /**
     * @param  array<string, mixed>  $agency
     * @param  array<string, string|null>  $requested
     * @param  array<string, string|null>  $confirmed
     * @param  array<string, string|null>  $nextAction
     * @param  array<string, mixed>  $publicMessage
     */
    public function __construct(
        public string $reference,
        public array $agency,
        public array $requested,
        public array $confirmed,
        public BookingStatus $bookingStatus,
        public DocumentReadinessStatus $documentReadinessStatus,
        public array $nextAction,
        public array $publicMessage,
    ) {}

    public static function fromBooking(Booking $booking): self
    {
        $booking->loadMissing(['agency', 'documentReadiness']);

        $agency = $booking->agency;
        $documentReadiness = $booking->documentReadiness;

        return new self(
            reference: $booking->reference,
            agency: [
                'slug' => $agency->slug,
                'name' => [
                    'fr' => $agency->name_fr,
                    'en' => $agency->name_en,
                ],
                'address' => [
                    'fr' => $agency->address_fr,
                    'en' => $agency->address_en,
                ],
                'city' => $agency->city,
                'quarter' => $agency->quarter,
                'phones' => $agency->phones ?? [],
                'whatsapp' => $agency->whatsapp,
                'email' => $agency->email,
                'map_link' => $agency->map_link,
            ],
            requested: [
                'date' => $booking->preferred_date?->toDateString(),
                'time_slot' => $booking->preferred_time_slot,
            ],
            confirmed: [
                'date' => $booking->confirmed_date?->toDateString(),
                'time_slot' => $booking->confirmed_time_slot,
            ],
            bookingStatus: $booking->status,
            documentReadinessStatus: $documentReadiness?->status ?? DocumentReadinessStatus::NotReviewed,
            nextAction: [
                'fr' => $documentReadiness?->next_action_fr,
                'en' => $documentReadiness?->next_action_en,
            ],
            publicMessage: [
                'booking' => $booking->public_message,
                'document' => [
                    'fr' => $documentReadiness?->public_message_fr,
                    'en' => $documentReadiness?->public_message_en,
                ],
            ],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'reference' => $this->reference,
            'agency' => $this->agency,
            'requested' => $this->requested,
            'confirmed' => $this->confirmed,
            'booking_status' => $this->bookingStatus->value,
            'document_status' => $this->documentReadinessStatus->value,
            'next_action' => $this->nextAction,
            'public_message' => $this->publicMessage,
        ];
    }
}
