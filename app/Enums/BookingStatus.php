<?php

namespace App\Enums;

enum BookingStatus: string
{
    case NewRequest = 'new_request';
    case PendingConfirmation = 'pending_confirmation';
    case Confirmed = 'confirmed';
    case Rescheduled = 'rescheduled';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
    case NoShow = 'no_show';
}
