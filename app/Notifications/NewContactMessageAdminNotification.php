<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessageAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ContactMessage $contactMessage,
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
        $contactMessage = $this->contactMessage->loadMissing('agency');

        return (new MailMessage)
            ->subject('Nouveau message de contact GS AUTOBILAN')
            ->greeting('Nouveau message de contact')
            ->line('Nom: '.$contactMessage->name)
            ->line('Sujet: '.$contactMessage->subject)
            ->line('Telephone: '.($contactMessage->phone ?? 'Non renseigne'))
            ->line('Email: '.($contactMessage->email ?? 'Non renseigne'))
            ->line('Agence: '.($contactMessage->agency?->name_fr ?? 'Non assignee'))
            ->line('Message: '.$contactMessage->message);
    }
}
