<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class BookingPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function view(User $user, Booking $booking): bool
    {
        return $this->ownsAgency($user, $booking->agency_id);
    }

    public function create(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function update(User $user, Booking $booking): bool
    {
        return $this->ownsAgency($user, $booking->agency_id);
    }

    public function delete(User $user, Booking $booking): bool
    {
        return false;
    }
}
