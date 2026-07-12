<?php

namespace App\Policies;

use App\Models\Agency;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class AgencyPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function view(User $user, Agency $agency): bool
    {
        return $this->ownsAgency($user, $agency->id);
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Agency $agency): bool
    {
        return false;
    }

    public function delete(User $user, Agency $agency): bool
    {
        return false;
    }
}
