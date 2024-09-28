<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PopUpController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NormalAdsController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\FiltrationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\RepresentativeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/customers.php';



Route::middleware('auth')->group(function () {

    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations.index');

    Route::put('configurations/update', [ConfigurationController::class, 'update'])->name('configurations.update');

    Route::resource('/countries',CountryController::class);

    Route::post('/currency',[CurrencyController::class,'store'])->name('currency.store');

    Route::resource('categories', CategoryController::class);

    Route::resource('customers', CustomerController::class);

    Route::post('customers/{customer}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggleStatus');

    Route::resource('normalads', NormalAdsController::class);

    Route::get('export/ads/', [NormalAdsController::class,'export'])->name('export.ads');

    Route::get('normaladsCategory', [NormalAdsController::class,'selectCategory'])->name('normaladsCategory');

    // web.php
    Route::post('ads/{ad}/toggle-status', [NormalAdsController::class, 'toggleStatus'])->name('normalads.toggleStatus');

      Route::post('commercial/{ad}/toggle-status', [CommercialController::class, 'toggleStatus'])->name('commercial.toggleStatus');



    Route::resource('banners', BannerController::class);

     Route::delete('/banners/photo/{id}', [BannerController::class, 'deletePhoto'])->name('banners.deletePhoto');

    Route::resource('commercialads', CommercialController::class);

    Route::get('export/commercial/', [CommercialController::class,'export'])->name('export.commercial');


    Route::resource('representative', RepresentativeController::class);

    Route::post('/image/remove', [CommercialController::class, 'removeImage'])->name('image.remove');


    Route::resource('popup', PopUpController::class);
    Route::post('popup/{ad}/toggle-status', [PopUpController::class, 'toggleStatus'])->name('popup.toggleStatus');


    Route::get('/viewMainCategory', [AdsController::class, 'MainCategory'])->name('viewMainCategory');

    Route::get('/getRelatedAds/{cat_id}', [AdsController::class, 'getRelatedAds'])->name('getRelatedAds');

    Route::get('/viewSubCategory/{catId}', [OfferController::class, 'viewSubCategory'])->name('viewSubCategory');



    Route::get('/subcategory/{catId}/redirect', [OfferController::class, 'redirectToView'])->name('subcategory.redirect');

    Route::get('/filters/{cat_id}', [FiltrationController::class, 'showFilters'])->name('show.filters');

    Route::get('/filters', [FiltrationController::class, 'MainCategory'])->name('index.filters');

    Route::get('/apply-filters/{cat_id}', [FiltrationController::class, 'applyFilters'])->name('apply.filters');



    Route::post('/update-country-session', [CountryController::class, 'updateCountrySession'])
    ->middleware('can:update.countries')
    ->name('updateCountrySession');

    Route::resource('subscriptions', SubscriptionController::class);



    Route::resource('role', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::post('/roles/{role}/permissions', [RoleController::class,'storePermissions'])->name('roles.permissions.store');
    Route::get('/roles/{roleId}/permissions/assign', [RoleController::class,'role_permission'])->name('roles.permissions.view');



    Route::post('/assign-role/{userId}', [UserController::class, 'assignRole'])->name('assign.role');

    Route::resource('AdminUsers', UserController::class);

    Route::put('/user/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');


    Route::resource('commercialads', CommercialController::class);

    Route::resource('bills', BillController::class);

    Route::get('/invoice/print/{id}', [BillController::class, 'printInvoice'])->name('invoice.print');


});




Route::get('lang', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('location', [LocationController::class, 'getLocation']);

Route::get('lang/home', [LanguageController::class, 'index']);

Route::get('lang/change', [LanguageController::class, 'change'])->name('changeLang');

Route::post('lang/translate', [LanguageController::class, 'translate'])->name('translateText');
