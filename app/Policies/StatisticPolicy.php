<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\Statistic;
use App\Models\User;

class StatisticPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole([RolesEnum::ADMIN, RolesEnum::MANAGER]);
    }

    public function view(User $user, Statistic $statistic): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Statistic $statistic): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Statistic $statistic): bool
    {
        return $this->viewAny($user);
    }

    public function deleteAny(User $user): bool
    {
        return $this->viewAny($user);
    }
}
