<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Tenders\TenderController;
use App\Http\Controllers\Api\Tenders\ApplicantController;




Route::middleware('auth:sanctum')->group(function () {



    Route::post('/ApiFileTender', [ApplicantController::class, 'store']);


    Route::resource('/ApiAllTenders', TenderController::class);

});




Route::post('/ApiRegister', [RegisterController::class, 'register']);

Route::post('/ApiVerify', [RegisterController::class, 'verify']);

Route::post('/ApiLogin', [LoginController::class, 'login']);




