<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BreadcrumbService;

class BreadcrumbServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BreadcrumbService::class, function ($app) {
            return new BreadcrumbService();
        });
    }

    public function boot()
    {
        // You can add boot logic here if needed, such as publishing config files or other setup tasks.  This is usually not needed for simple services.
    }
}
