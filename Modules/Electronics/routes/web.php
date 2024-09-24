<?php

use Illuminate\Support\Facades\Route;
use Modules\Electronics\Http\Controllers\DeviceController;
use Modules\Electronics\Http\Controllers\MobileController;
use Modules\Electronics\Http\Controllers\ElectronicsController;
use Modules\Electronics\Http\Controllers\ElectronicCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([], function () {
    Route::resource('electronics', ElectronicsController::class)->names('electronics');
    Route::get('CommercialCar', [CarController::class,'commercial'])->name('car.commercial');

    Route::resource('electronic-categories', ElectronicCategoryController::class);

    Route::resource('mobile-normalAds', MobileController::class);

    Route::get('CommercialMobiles', [MobileController::class,'commercial'])->name('Mobiles.commercial');

    Route::post('mobiles/{ad}/toggle-status', [MobileController::class, 'toggleStatusMobile'])->name('mobile.toggleStatus');


});
Route::get('/create/electronic/{catId}',[ElectronicsController::class, 'categoryCreate'])->name('electronic.category.create');
