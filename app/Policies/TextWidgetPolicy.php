<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\User;

class TextWidgetPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole([RolesEnum::ADMIN, RolesEnum::MANAGER]);
    }
}
