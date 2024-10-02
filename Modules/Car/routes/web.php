<?php

use Illuminate\Support\Facades\Route;
use Modules\Car\Http\Controllers\CarController;
use Modules\Car\Http\Controllers\BrandController;
use Modules\Car\Http\Controllers\CarFeatureController;
use Modules\Car\Http\Controllers\CarCategoryController;

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

Route::middleware('auth')->group(function () {
    
    Route::resource('car', CarController::class)->names('car');

    Route::get('/Commercial/Car', [CarController::class,'commercial'])->name('commercialCAR');

    Route::resource('car-features', CarFeatureController::class)->except('destroy');

    Route::resource('car-brands', BrandController::class);

    Route::delete('/car-features/{id}', [CarFeatureController::class, 'destroy'])->name('car-features.destroy');


});

