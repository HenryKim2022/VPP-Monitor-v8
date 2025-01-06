<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

use App\Models\DaftarWS_Model;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ADDED TO TAKEN CSS NOTLOADING IN HTTPS
        if (env(key: 'APP_ENV') === 'local' && request()->server(key: 'HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme(scheme: 'https');
        }

        $this->app->register(BreadcrumbServiceProvider::class);
        $this->app->register(RecaptchaServiceProvider::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        if (env(key: 'APP_ENV') !== 'local') {
            URL::forceScheme(scheme: 'https');
        }
        //
        Validator::extend('unique_working_date_ws', function ($attribute, $value, $parameters, $validator) {
            $existingDate = DaftarWS_Model::where('working_date_ws', $value)->exists();
            return !$existingDate;
        });
    }
}
