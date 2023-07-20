<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Services\ResponseService;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Globalize Services for resulting reponses of API
        $this->app->bind('App\Library\Services\ResponseService', function ($app) {
            return new ResponseService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
