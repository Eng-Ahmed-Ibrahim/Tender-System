<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\LoginController;
use App\Http\Controllers\Customer\RegsiterController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\CommercialController;
use App\Http\Controllers\Customer\CustomerAdsController;
use App\Http\Controllers\Customer\SubscriptionController;




Route::get('customer/register',[RegsiterController::class, 'create'])->name('customer.register.view');

Route::post('customer/register',[RegsiterController::class, 'store'])->name('customer.register');

Route::get('customer/login',[LoginController::class, 'create'])->name('customer.login.view');

Route::post('customer/login',[LoginController::class, 'store'])->name('customer.login');

Route::middleware(['auth:customer'])->group(function () {

    Route::get('customer/dashboard', [DashboardController::class, 'index'])->name('customer.dashboard');

    Route::get('showCommercial/{id}', [DashboardController::class, 'showCommercialAd'])->name('showCommercialAd');

    Route::get('showNormalAd/{id}', [DashboardController::class, 'showNormalAd'])->name('showNormalAd');

    Route::post('customer/logout', [LoginController::class, 'logout'])->name('customer.logout');

    Route::get('customers/ads/create',[CustomerAdsController::class ,'create'])->name('ads.customer.create');

    Route::get('/subcategories/{type}/{categoryId}', [CustomerAdsController::class, 'getSubcategories']);


    Route::get('/ads/customers/{cat_id}', [CustomerAdsController::class, 'createView'])->name('ads.customer.createAds');

    Route::get('/ads/CustomerNormal', [CustomerAdsController::class, 'normal'])->name('normal.customer.index');

    Route::post('ads/customers/{cat_id}', [CustomerAdsController::class, 'store'])->name('ads.customer.store');

    Route::get('ads/create/house/{cat_id}', [CustomerAdsController::class, 'createHouseAds'])->name('ads.createHouseAds');

    Route::get('ads/create/electronic/{cat_id}', [CustomerAdsController::class, 'createElectronicAds'])->name('ads.createElectronicAds');
    
    Route::get('ads/create/car/{cat_id}', [CustomerAdsController::class, 'createCarAds'])->name('ads.createCarAds');

    Route::get('ads/create/bike/{cat_id}', [CustomerAdsController::class, 'createBikeAds'])->name('ads.createBikeAds');

    Route::get('customers/commercail/create',[CommercialController::class ,'create'])->name('commercial.customer.create');

// Route definition with both parameters
Route::get('/commercial/customers/{cat_id}/{type}', [CommercialController::class, 'createView'])->name('commercial.customer.createAds');

    Route::get('/ads/CustomerCommercail', [CommercialController::class, 'index'])->name('commercial.customer.index');

    Route::post('/ads/CustomerCommercail', [CommercialController::class, 'store'])->name('commercial.customer.store');

    Route::get('/customer/subscriptions',[SubscriptionController::class, 'showPlans'])->name('customers.subscriptions');

    Route::post('/customer/subscriptions',[SubscriptionController::class, 'selectPlan'])->name('customers.subscriptions.store');

});



