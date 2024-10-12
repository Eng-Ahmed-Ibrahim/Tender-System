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
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\RepresentativeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('backend.dashboard.index');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

Route::get('/company/dashboard', function () {
    return view('company.dashboard.index');
})->middleware(['auth', 'verified'])->name('company.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/customers.php';



Route::middleware('auth')->group(function () {



    Route::post('/update-country-session', [CountryController::class, 'updateCountrySession'])
    ->name('updateCountrySession');

    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations.index');

    Route::put('configurations/update', [ConfigurationController::class, 'update'])->name('configurations.update');


    Route::resource('role', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::post('/roles/{role}/permissions', [RoleController::class,'storePermissions'])->name('roles.permissions.store');

    Route::get('/roles/{roleId}/permissions/assign', [RoleController::class,'role_permission'])->name('roles.permissions.view');



    Route::post('/assign-role/{userId}', [UserController::class, 'assignRole'])->name('assign.role');

    Route::resource('AdminUsers', UserController::class);

    Route::put('/user/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');



    
    Route::resource('UserProfile', AdminProfileController::class);
    Route::post('/update-email', [AdminProfileController::class, 'updateEmail'])->name('update.email');


});




Route::get('lang', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('location', [LocationController::class, 'getLocation']);

Route::get('lang/home', [LanguageController::class, 'index']);

Route::get('lang/change', [LanguageController::class, 'change'])->name('changeLang');
