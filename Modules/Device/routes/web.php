<?php

use Illuminate\Support\Facades\Route;
use Modules\Device\Http\Controllers\DeviceController;

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
    Route::resource('/Normal/deviceNormal', DeviceController::class)->names('Normaldevice');
    Route::get('CommercialDevice', [DeviceController::class,'commercial'])->name('device.commercial');

});
