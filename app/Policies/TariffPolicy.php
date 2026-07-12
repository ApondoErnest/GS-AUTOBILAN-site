<?php

namespace App\Policies;

use App\Models\Tariff;
use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;

class TariffPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Tariff $tariff): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Tariff $tariff): bool
    {
        return false;
    }

    public function delete(User $user, Tariff $tariff): bool
    {
        return false;
    }
}
