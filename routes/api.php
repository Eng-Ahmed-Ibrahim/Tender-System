<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Tenders\TenderController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::post('/ApiRegister', [RegisterController::class, 'register']);

Route::post('/ApiVerify', [RegisterController::class, 'verify']);

Route::post('/ApiLogin', [LoginController::class, 'login']);


Route::resource('/ApiAllTenders', TenderController::class);


