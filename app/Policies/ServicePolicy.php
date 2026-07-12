<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class ServicePolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isContentManager($user);
    }

    public function view(User $user, Service $service): bool
    {
        return $this->isContentManager($user);
    }

    public function create(User $user): bool
    {
        return $this->isContentManager($user);
    }

    public function update(User $user, Service $service): bool
    {
        return $this->isContentManager($user);
    }

    public function delete(User $user, Service $service): bool
    {
        return $this->isContentManager($user);
    }
}
