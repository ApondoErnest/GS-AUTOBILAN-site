<?php

namespace App\Listeners;

use App\Events\ContactMessageCreated;
use App\Listeners\Concerns\ResolvesAdminNotificationRecipient;
use App\Notifications\NewContactMessageAdminNotification;
use Illuminate\Support\Facades\Notification;

class SendAdminContactMessageNotification
{
    use ResolvesAdminNotificationRecipient;

    public bool $afterCommit = true;

    public function handle(ContactMessageCreated $event): void
    {
        $email = $this->adminEmail();

        if ($email === null) {
            return;
        }

        Notification::route('mail', $email)
            ->notify(new NewContactMessageAdminNotification($event->contactMessage));
    }
}
