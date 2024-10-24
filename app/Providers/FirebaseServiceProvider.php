<?php

namespace App\Providers;

use Kreait\Firebase\Factory;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('firebase', function ($app) {
            return (new Factory)
                ->withServiceAccount(storage_path('app/firebase.json'))
                ->createMessaging();
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
