<?php

namespace App\Providers;

use App\Models\CustomerSubscription;
use Illuminate\Support\ServiceProvider;
use App\Observers\CustomerSubscriptionObserver;
use Illuminate\Pagination\Paginator as PaginationPaginator;

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
        CustomerSubscription::observe(CustomerSubscriptionObserver::class);
        PaginationPaginator::useBootstrapFour();
    }
}
