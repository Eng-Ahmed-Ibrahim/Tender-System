<?php

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserDashboard;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AdminTenderController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CompanyUsersController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\Company\TenderController;


Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        return redirect()->route($user->role === 'admin' ? 'admin.dashboard' : 'company.dashboard');
    }
    return view('welcome');
});


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->middleware(['auth', UserDashboard::class . ':admin'])->name('admin.dashboard');

Route::get('/company/dashboard', [DashboardController::class, 'company'])->name('company.dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';



Route::middleware('auth')->group(function () {




    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations.index');

    Route::put('configurations/update', [ConfigurationController::class, 'update'])->name('configurations.update');


    Route::resource('role', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::post('/roles/{role}/permissions', [RoleController::class, 'storePermissions'])->name('roles.permissions.store');

    Route::get('/roles/{roleId}/permissions/assign', [RoleController::class, 'role_permission'])->name('roles.permissions.view');


    Route::resource('companies', CompanyController::class);

    Route::patch('/companies/{id}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggle-status');
    Route::post('/assign-role/{userId}', [UserController::class, 'assignRole'])->name('assign.role');

    Route::resource('AdminUsers', UserController::class);

    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');

    Route::get('/AdminUsers/{userId}/edit_user', [UserController::class, 'edit_user']);


    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])
        ->name('users.toggle-status');

    Route::resource('CompanyUsers', CompanyUsersController::class);

    Route::resource('Applicants', ApplicantController::class);

    Route::get('/applicants/users', [ApplicantController::class, 'users'])->name('applicants.users');

    Route::put('/user/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');




    Route::resource('UserProfile', AdminProfileController::class);


    Route::post('/update-email', [AdminProfileController::class, 'updateEmail'])->name('update.email');


    Route::get('location', [LocationController::class, 'getLocation']);

    Route::get('lang/home', [LanguageController::class, 'index']);

    Route::get('lang/change', [LanguageController::class, 'change'])->name('changeLang');


    Route::resource('tenders', TenderController::class);

    Route::get('/tenders/export/{format}', [TenderController::class, 'export'])
        ->name('tenders.export')
        ->where('format', 'excel|pdf');

    Route::post('/tenders/{id}/stop', [TenderController::class, 'stopTender'])->name('stopTender');

    Route::get('/tenders/{id}/qrcode', [TenderController::class, 'generateQrCode'])->name('tenders.qrcode');

    Route::get('/tenders/{id}/download', [TenderController::class, 'download'])->name('tenders.download');

    Route::resource('Admintenders', AdminTenderController::class);

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');

    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');

    Route::post('/admin/users/import', [UserController::class, 'importUsers'])->name('AdminUsers.import');

    Route::prefix("/admin/countries")->name("admin.country.")->controller(CountryController::class)->group(function () {
        Route::get('/', 'index')->name("index");
        Route::post('/add-counry', 'store')->name('store');
        Route::put('/update-counry/{id}', 'update')->name('update');
        Route::delete('/delete-counry/{id}', 'delete')->name('delete');
    });
    Route::prefix('admin/cities')->name('admin.city.')->controller(CityController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::put('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
});

Route::post('/save-token', [NotificationController::class, 'saveToken']);
