<?php

namespace App\Policies;

use App\Models\User;
use App\Policies\Concerns\HandlesPolicyRoles;
use Illuminate\Database\Eloquent\Model;

class ContentPolicy
{
    use HandlesPolicyRoles;

    public function viewAny(User $user): bool
    {
        return $this->isContentManager($user);
    }

    public function view(User $user, Model $content): bool
    {
        return $this->isContentManager($user);
    }

    public function create(User $user): bool
    {
        return $this->isContentManager($user);
    }

    public function update(User $user, Model $content): bool
    {
        return $this->isContentManager($user);
    }

    public function delete(User $user, Model $content): bool
    {
        return $this->isContentManager($user);
    }
}
