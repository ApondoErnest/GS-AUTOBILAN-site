<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBookingAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Booking $booking,
    ) {}

    /**
     * @return list<string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $booking = $this->booking->loadMissing(['agency', 'service']);

        return (new MailMessage)
            ->subject('Nouvelle demande de rendez-vous '.$booking->reference)
            ->greeting('Nouvelle demande de rendez-vous')
            ->line('Reference: '.$booking->reference)
            ->line('Client: '.$booking->customer_name)
            ->line('Telephone: '.$booking->phone)
            ->line('Agence: '.$booking->agency?->name_fr)
            ->line('Service: '.$booking->service?->title_fr)
            ->line('Date souhaitee: '.$booking->preferred_date?->toDateString().' '.$booking->preferred_time_slot)
            ->line('Statut initial: '.$booking->status->value);
    }
}
