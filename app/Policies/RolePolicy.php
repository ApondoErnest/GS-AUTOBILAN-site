<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Role $role): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Role $role): bool
    {
        return false;
    }

    public function delete(User $user, Role $role): bool
    {
        return false;
    }
}
