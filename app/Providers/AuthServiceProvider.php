<?php

namespace App\Providers;

use App\Models\LogistikItem;
use App\Policies\LogistikItemPolicy;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        LogistikItem::class => LogistikItemPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // IZIN untuk menu/logistik (index, create, store)
        Gate::define('logistik.manage', function (User $user) {
            // kamu pakai Spatie Permission, jadi gunakan hasRole()
            return $user->hasRole('KL') || $user->hasRole('Super Admin');
        });
    }
}
