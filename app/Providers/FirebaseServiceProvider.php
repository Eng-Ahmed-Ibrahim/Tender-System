<?php

namespace App\Providers;

use Exception;
use GuzzleHttp\Client;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Factory::class, function ($app) {
            // Use absolute path with storage_path helper
            $credentialsPath = storage_path('app/firebase.json');
            
            // Debug information (you can remove after fixing)
            Log::info('Firebase credentials path', [
                'path' => $credentialsPath,
                'exists' => file_exists($credentialsPath),
                'readable' => is_readable($credentialsPath)
            ]);

            if (!file_exists($credentialsPath)) {
                throw new Exception("Firebase credentials file not found at: {$credentialsPath}");
            }

            if (!is_readable($credentialsPath)) {
                // Try to fix permissions automatically for Windows
                chmod($credentialsPath, 0644);
                
                if (!is_readable($credentialsPath)) {
                    throw new Exception("Firebase credentials file is not readable at: {$credentialsPath}");
                }
            }

            return (new Factory)->withServiceAccount($credentialsPath);
        });

        $this->app->singleton(Messaging::class, function ($app) {
            return $app->make(Factory::class)->createMessaging();
        });

        $this->app->singleton(\App\Services\FirebaseService::class, function ($app) {
            return new \App\Services\FirebaseService(
                $app->make(Messaging::class)
            );
        });
    }
}