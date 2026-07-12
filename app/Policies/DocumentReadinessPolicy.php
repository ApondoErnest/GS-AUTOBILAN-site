<?php

namespace App\Policies;

use App\Models\DocumentReadiness;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class DocumentReadinessPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function view(User $user, DocumentReadiness $documentReadiness): bool
    {
        return $this->ownsAgency($user, $documentReadiness->booking?->agency_id);
    }

    public function create(User $user): bool
    {
        return $this->isAgencyAdmin($user) && $user->assigned_agency_id !== null;
    }

    public function update(User $user, DocumentReadiness $documentReadiness): bool
    {
        return $this->ownsAgency($user, $documentReadiness->booking?->agency_id);
    }

    public function delete(User $user, DocumentReadiness $documentReadiness): bool
    {
        return false;
    }
}
