<?php

namespace App\Policies;

use App\Models\LogistikItem;
use App\Models\User;

class LogistikItemPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('KL') || $user->hasRole('Super Admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('KL') || $user->hasRole('Super Admin');
    }

    public function update(User $user, LogistikItem $item): bool
    {
        return $user->hasRole('Super Admin') || ($user->hasRole('KL') && $item->created_by == $user->id);
    }

    public function delete(User $user, LogistikItem $item): bool
    {
        return $user->hasRole('Super Admin') || ($user->hasRole('KL') && $item->created_by == $user->id);
    }
}
