<?php

namespace App\Policies;

use App\Models\Sop;
use App\Models\User;

class SopPolicy
{
    /** Semua role yang boleh akses SOP */
    private array $allowed = ['Super Admin', 'PK', 'KL', 'RR'];

    private function sameRole(User $user, Sop $sop): bool
    {
        $uRole = $user->getRoleNames()->first();   // spatie/permission
        return mb_strtolower($uRole ?? '') === mb_strtolower($sop->owner_role ?? '');
    }

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole($this->allowed);
    }

    public function view(User $user, Sop $sop): bool
    {
        return $this->viewAny($user) && ($user->hasRole('Super Admin') || $this->sameRole($user, $sop));
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Sop $sop): bool
    {
        return $user->hasRole('Super Admin') || $this->sameRole($user, $sop);
    }

    public function delete(User $user, Sop $sop): bool
    {
        return $user->hasRole('Super Admin') || $this->sameRole($user, $sop);
    }

    public function publish(User $user, Sop $sop): bool
    {
        // semua role boleh publish selama SOP itu milik role-nya
        return $this->view($user, $sop);
    }
}
