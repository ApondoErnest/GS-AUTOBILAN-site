<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class SettingPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Setting $setting): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Setting $setting): bool
    {
        return false;
    }

    public function delete(User $user, Setting $setting): bool
    {
        return false;
    }
}
