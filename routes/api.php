<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiCountryDetection;
use App\Http\Controllers\Api\ads\Normalcontroller;
use App\Http\Controllers\RepresentativeController;
use App\Http\Controllers\Api\Popup\PopupController;
use App\Http\Controllers\Api\ConfigurationController;
use App\Http\Controllers\Api\Normalads\CarController;
use App\Http\Controllers\Api\Search\SearchController;
use App\Http\Controllers\Api\Banners\BannerController;
use App\Http\Controllers\Api\Normalads\BikeController;
use App\Http\Controllers\Api\Normalads\CareerController;
use App\Http\Controllers\Api\Normalads\MobileController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Search\FiltrationController;
use App\Http\Controllers\Api\Normalads\PropertyController;
use App\Http\Controllers\Api\Normalads\NormaladsController;
use App\Http\Controllers\Api\Customers\auth\LoginController;
use App\Http\Controllers\Api\Commercial\CommercialController;
use App\Http\Controllers\Api\Customers\auth\RegisterController;
use App\Http\Controllers\Api\Commercial\CarCommercialController;
use App\Http\Controllers\Api\Commercial\BikeCommercialController;
use App\Http\Controllers\Api\Customers\Profile\ProfileController;
use App\Http\Controllers\Api\Commercial\CareerCommercialController;
use App\Http\Controllers\Api\Commercial\MobileCommercialController;
use App\Http\Controllers\Api\customers\ads\NormalCustomerController;
use App\Http\Controllers\Api\Commercial\PropertyCommercialController;
use App\Http\Controllers\Api\Representatives\RepresntativeController;
use App\Http\Controllers\Api\Customers\Profile\SubscriptionController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::post('/register/email-phone', [RegisterController::class, 'registerEmailPhone']);
Route::post('/register/complete', [RegisterController::class, 'completeRegistration']);


Route::post('/login/customers',[LoginController::class , 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('logout/customers', [LoginController::class, 'logout']);
    

    Route::apiResource('ApiProfile',ProfileController::class);

    Route::get('/subscription/plans', [SubscriptionController::class, 'showPlans']);

    Route::post('/subscription/select', [SubscriptionController::class, 'selectPlan']);

    Route::get('/subscription/customerPlan', [SubscriptionController::class, 'customerPlan']);

    Route::apiResource('ApiNormalAds', NormaladsController::class);




    
    Route::apiResource('ApiCars',CarController::class);

    Route::get('/carFeaturesApi', [CarController::class, 'carFeatures']);

    Route::get('/carBrandsApi', [CarController::class, 'carBrands']);

    
    
    Route::apiResource('ApiBikes',BikeController::class);
    
    Route::apiResource('ApiProperty',PropertyController::class);

    Route::apiResource('ApiMobile',MobileController::class);

    Route::apiResource('ApiCareer',CareerController::class);



    Route::apiResource('ApiCommercialAds', CommercialController::class);

    Route::apiResource('ApiPopupAds', PopupController::class);


    Route::apiResource('ApiAllNormal', Normalcontroller::class);

    Route::apiResource('ApiBanners', BannerController::class);


    Route::apiResource('ApiRepresntatives', RepresntativeController::class);



    Route::apiResource('ApiCustomer/Ads', NormalCustomerController::class);

    

    Route::post('/register/social', [RegisterController::class, 'social']);

    Route::apiResource('ApiSearch',SearchController::class);

    Route::get('/categories/{id}/related', [SearchController::class, 'getRelatedItems'])->name('categories.related');
    
    Route::get('/search-ads', [SearchController::class, 'searchAds']);
    
    
    
    Route::get('/mainCategory',[CategoryController::class , 'MainCategory']);
    
    Route::get('/SubCategory/{cat_id}',[CategoryController::class , 'SubCategory']);
    
    Route::get('filters/{cat_id}', [FiltrationController::class, 'showFilters']);
    
    Route::post('apply-filters/{cat_id}', [FiltrationController::class, 'applyFilters']);
    
    Route::get('ApiGetRelatedAds/{cat_id}', [FiltrationController::class, 'getRelatedAds']);


});


Route::apiResource('ApiConfiguration',ConfigurationController::class);

Route::get('IsEmptyfilters/{cat_id}', [FiltrationController::class, 'isFilter']);





