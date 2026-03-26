<?php

namespace App\Policies;

use App\Models\User;
use App\Enums\RolesEnum;
class FilePolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([RolesEnum::ADMIN, RolesEnum::MANAGER]);
    }
}
