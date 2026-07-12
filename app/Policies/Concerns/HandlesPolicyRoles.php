<?php

namespace App\Policies\Concerns;

use App\Models\User;

trait HandlesPolicyRoles
{
    public function before(User $user, string $ability): ?bool
    {
        return $this->isSuperAdmin($user) ? true : null;
    }

    protected function isSuperAdmin(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    protected function isAgencyAdmin(User $user): bool
    {
        return $user->hasRole('agency_admin');
    }

    protected function isContentManager(User $user): bool
    {
        return $user->hasRole('content_manager');
    }

    protected function ownsAgency(User $user, ?int $agencyId): bool
    {
        return $this->isAgencyAdmin($user)
            && $agencyId !== null
            && $user->assigned_agency_id !== null
            && (int) $user->assigned_agency_id === (int) $agencyId;
    }
}
