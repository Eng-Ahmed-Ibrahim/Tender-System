<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Tenders\TenderController;
use App\Http\Controllers\Api\Profile\ProfileController;
use App\Http\Controllers\Api\UserNotifcationController;
use App\Http\Controllers\Api\Tenders\ApplicantController;
use App\Http\Controllers\Api\Auth\PasswordResetController;



Route::post("/send-otp", [OtpController::class, 'send_otp']);
Route::post("/verify-account", [OtpController::class, 'verify_otp']);
Route::post("/resend-otp", [OtpController::class, 'resend_otp']);


Route::get('/getCities', [TenderController::class, 'getCities']);

Route::middleware('auth:sanctum','VerifiedAccount')->get('/test-auth', function () {
    return response()->json(['user' => auth()->user()]);
});

Route::middleware(['auth:sanctum','VerifiedAccount', 'throttle:1,20'])->group(function () {
    Route::get('/tenders', [TenderController::class, 'index']);
});


Route::middleware('auth:sanctum','VerifiedAccount')->group(function () {


    Route::post('/tenders/{tenderId}/favorite', [FavoriteController::class, 'store']);

    Route::delete('/tenders/{tenderId}/favorite', [FavoriteController::class, 'destroy']);

    Route::post('/ApiFileTender', [ApplicantController::class, 'store']);

    Route::put('/ApiFileTenderUpdate', [ApplicantController::class, 'update']);


    Route::get('/Apiconfiguration', [TenderController::class, 'configuration']);

    Route::get('/ApiAllTenders/{tender}', [TenderController::class, 'show']);

    Route::get('/tenders/{Id}/company', [ApplicantController::class, 'getUsersByTenderId']);

    Route::get('/deadline/{tenderId}/', [ApplicantController::class, 'deadline']);

    Route::get('/min_max_insurance', [TenderController::class, 'min_max_insurance']);
    
    Route::delete('applications/file', [ApplicantController::class, 'deleteFile']);

    
    Route::get('/ApiAllTenders', [TenderController::class, 'index']);
});  
Route::controller(CountryController::class)->group(function(){
    Route::get('/countries','countries');
    Route::get('/cities','cities');
});

Route::middleware('auth:sanctum','VerifiedAccount')->group(function () {

    Route::prefix('notifications')->group(function () {
        Route::get('/', [UserNotifcationController::class, 'getNotifications']);
        Route::get('/unread', [UserNotifcationController::class, 'getUnreadNotifications']);
        Route::post('/{id}/read', [UserNotifcationController::class, 'markAsRead']);
        Route::post('/read-all', [UserNotifcationController::class, 'markAllAsRead']);
    });
});


Route::post('/password/send-code', [PasswordResetController::class, 'sendVerificationCode']);
Route::post('/password/verify-code', [PasswordResetController::class, 'verifyCode']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);


Route::post('/ApiRegister', [RegisterController::class, 'register']);

Route::post('/ApiVerify', [RegisterController::class, 'verify']);

Route::post('/ApiLogin', [LoginController::class, 'login']);



Route::middleware('auth:sanctum','VerifiedAccount')->group(function () {
    
    Route::get('/Apiprofile', [ProfileController::class, 'user_profile']);
    Route::post('/Apilogout', [ProfileController::class, 'logout']);
    Route::post('/Apiprofile/update', [ProfileController::class, 'updateProfile']);
    Route::post('/Apiprofile/verify-profile-updates', [ProfileController::class, 'verifyProfileUpdates']);
    Route::post('/Apiprofile/change-password', [ProfileController::class, 'changePassword']);
    Route::post('/Apiprofile/change-photo', [ProfileController::class, 'changePhoto']);

    Route::post('/store-fcm-token', [NotificationController::class, 'storeFcmToken']);

    Route::delete('profile/delete', [ProfileController::class, 'deleteAccount']);

});




// Send FCM notification

Route::post('/notifications/send', [NotificationController::class, 'sendNotification']);