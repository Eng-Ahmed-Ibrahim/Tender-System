<?php

use Illuminate\Support\Facades\Route;
use Modules\House\Http\Controllers\HouseController;
use Modules\House\Http\Controllers\FeatureController;
use Modules\House\Http\Controllers\PopUpHouseController;
use Modules\House\Http\Controllers\HouseCategoryController;
use Modules\House\Http\Controllers\CommercailsHosueController;

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
    Route::resource('house', HouseController::class)->names('house');

    Route::get('CommercialHouse', [HouseController::class,'commercial'])->name('House.commercial');

    
Route::resource('house-categories', HouseCategoryController::class);
Route::resource('house-popup', PopUpHouseController::class);
Route::resource('house-features', FeatureController::class);
Route::get('/create/house/{catId}',[HouseController::class, 'categoryCreate'])->name('house.category.create');

Route::post('House/{ad}/toggle-status', [HouseController::class, 'toggleStatusHouse'])->name('house.toggleStatus');

});
