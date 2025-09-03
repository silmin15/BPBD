<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::componentNamespace('App\\View\\Components\\Form', 'form');
        Blade::componentNamespace('App\\View\\Components', 'ui');
        Blade::componentNamespace('App\\View\\Components\\Layout', 'layout');
    }
}
