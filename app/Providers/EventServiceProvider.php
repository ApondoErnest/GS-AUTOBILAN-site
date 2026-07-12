<?php

namespace App\Providers;

use App\Events\BookingCreated;
use App\Events\ContactMessageCreated;
use App\Listeners\SendAdminBookingNotification;
use App\Listeners\SendAdminContactMessageNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<class-string, list<class-string>>
     */
    protected $listen = [
        BookingCreated::class => [
            SendAdminBookingNotification::class,
        ],
        ContactMessageCreated::class => [
            SendAdminContactMessageNotification::class,
        ],
    ];
}
