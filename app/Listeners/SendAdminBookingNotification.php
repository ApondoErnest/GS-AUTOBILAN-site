<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Listeners\Concerns\ResolvesAdminNotificationRecipient;
use App\Notifications\NewBookingAdminNotification;
use Illuminate\Support\Facades\Notification;

class SendAdminBookingNotification
{
    use ResolvesAdminNotificationRecipient;

    public bool $afterCommit = true;

    public function handle(BookingCreated $event): void
    {
        $email = $this->adminEmail();

        if ($email === null) {
            return;
        }

        Notification::route('mail', $email)
            ->notify(new NewBookingAdminNotification($event->booking));
    }
}
