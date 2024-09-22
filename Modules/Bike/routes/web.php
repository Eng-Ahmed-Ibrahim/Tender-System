<?php

use Illuminate\Support\Facades\Route;
use Modules\Bike\Http\Controllers\BikeController;
use Modules\Bike\Http\Controllers\BikeFeatureController;
use Modules\Bike\Http\Controllers\BikeCategoryController;

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
    Route::resource('bike', BikeController::class)->names('bike');
    Route::resource('bike-categories', BikeCategoryController::class);

    Route::resource('bike-features', BikeFeatureController::class);

    Route::post('bikes/{ad}/toggle-status', [BikeController::class, 'toggleStatusBikes'])->name('bike.toggleStatus');

});
