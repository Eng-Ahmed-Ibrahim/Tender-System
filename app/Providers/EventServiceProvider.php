<?php

namespace App\Providers;

use App\Events\CustomerRegistered;
use App\Listeners\StoreCustomerLocation;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        
        CustomerRegistered::class => [
            StoreCustomerLocation::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
