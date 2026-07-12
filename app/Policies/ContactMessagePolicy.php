<?php

namespace App\Policies;

use App\Models\ContactMessage;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class ContactMessagePolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function view(User $user, ContactMessage $contactMessage): bool
    {
        return $this->ownsAgency($user, $contactMessage->agency_id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, ContactMessage $contactMessage): bool
    {
        return $this->ownsAgency($user, $contactMessage->agency_id);
    }

    public function delete(User $user, ContactMessage $contactMessage): bool
    {
        return false;
    }
}
