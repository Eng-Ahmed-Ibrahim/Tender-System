<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserDashboard;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CompanyController;
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
    return view('welcome');
});



Route::get('/admin/dashboard',[DashboardController::class, 'index'])->middleware(['auth', UserDashboard::class . ':admin'])->name('admin.dashboard');

Route::get('/company/dashboard',[DashboardController::class, 'company'])->middleware(['auth',UserDashboard::class . ':admin_company'])->name('company.dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware('auth')->group(function () {



   
    Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations.index');

    Route::put('configurations/update', [ConfigurationController::class, 'update'])->name('configurations.update');


    Route::resource('role', RoleController::class);

    Route::resource('permissions', PermissionController::class);

    Route::post('/roles/{role}/permissions', [RoleController::class,'storePermissions'])->name('roles.permissions.store');

    Route::get('/roles/{roleId}/permissions/assign', [RoleController::class,'role_permission'])->name('roles.permissions.view');

    Route::get('companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    Route::middleware(['permission:company.view'])->group(function () {
        Route::get('companies', [CompanyController::class, 'index'])->name('companies.index');

    });
    
    Route::middleware(['permission:company.create'])->group(function () {
        Route::get('companies/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('companies', [CompanyController::class, 'store'])->name('companies.store');
    });
    
    Route::middleware(['permission:company.edit'])->group(function () {
        Route::get('companies/{company}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('companies/{company}', [CompanyController::class, 'update'])->name('companies.update');
    });
    
    Route::middleware(['permission:company.delete'])->group(function () {
        Route::delete('companies/{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');
    });
    
   
    Route::post('/assign-role/{userId}', [UserController::class, 'assignRole'])->name('assign.role');


    Route::get('AdminUsers', [UserController::class, 'index'])->name('AdminUsers.index');
    Route::get('AdminUsers/{user}', [UserController::class, 'show'])->name('AdminUsers.show');


Route::middleware(['permission:employee.create'])->group(function () {
    Route::get('AdminUsers/create', [UserController::class, 'create'])->name('AdminUsers.create');
    Route::post('AdminUsers', [UserController::class, 'store'])->name('AdminUsers.store');
});

Route::middleware(['permission:employee.update'])->group(function () {
    Route::get('AdminUsers/{user}/edit', [UserController::class, 'edit'])->name('AdminUsers.edit');
    Route::put('AdminUsers/{user}', [UserController::class, 'update'])->name('AdminUsers.update');

Route::middleware(['permission:Employee.delete'])->group(function () {
    Route::delete('AdminUsers/{user}', [UserController::class, 'destroy'])->name('AdminUsers.destroy');
});

    
    Route::get('/users/export', [UserController::class, 'export'])->name('users.export');



    Route::resource('CompanyUsers', CompanyUsersController::class);


    

    Route::middleware(['permission:applicant.view'])->group(function () {
        Route::get('Applicants', [ApplicantController::class, 'index'])->name('Applicants.index');
        Route::get('Applicants/{applicant}', [ApplicantController::class, 'show'])->name('Applicants.show');

    });
    
    Route::middleware(['permission:applicant.create'])->group(function () {
        Route::get('Applicants/create', [ApplicantController::class, 'create'])->name('Applicants.create');
        Route::post('Applicants', [ApplicantController::class, 'store'])->name('Applicants.store');
    });
    
    Route::middleware(['permission:applicant.edit'])->group(function () {
        Route::get('Applicants/{applicant}/edit', [ApplicantController::class, 'edit'])->name('Applicants.edit');
        Route::put('Applicants/{applicant}', [ApplicantController::class, 'update'])->name('Applicants.update');
    });
    
    Route::middleware(['permission:applicant.delete'])->group(function () {
        Route::delete('Applicants/{applicant}', [ApplicantController::class, 'destroy'])->name('Applicants.destroy');
    });
    
  
    
    Route::put('/user/{user}/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');



    
    Route::resource('UserProfile', AdminProfileController::class);

    
    Route::post('/update-email', [AdminProfileController::class, 'updateEmail'])->name('update.email');


});

});


Route::post('/save-token', [NotificationController::class, 'saveToken']);




Route::get('location', [LocationController::class, 'getLocation']);

Route::get('lang/home', [LanguageController::class, 'index']);

Route::get('lang/change', [LanguageController::class, 'change'])->name('changeLang');




Route::middleware(['permission:tender.view'])->group(function () {
    Route::get('tenders', [TenderController::class, 'index'])->name('tenders.index');
    Route::get('tenders/{tender}', [TenderController::class, 'show'])->name('tenders.show');

});

Route::middleware(['permission:tender.create'])->group(function () {
    Route::get('tenders/create', [TenderController::class, 'create'])->name('tenders.create');
    Route::post('tenders', [TenderController::class, 'store'])->name('tenders.store');
});

Route::middleware(['permission:tender.update'])->group(function () {
    Route::get('tenders/{tender}/edit', [TenderController::class, 'edit'])->name('tenders.edit');
    Route::put('tenders/{tender}', [TenderController::class, 'update'])->name('tenders.update');
});

Route::middleware(['permission:tender.delete'])->group(function () {
    Route::delete('tenders/{tender}', [TenderController::class, 'destroy'])->name('tenders.destroy');
});


Route::get('/tenders/export/{format}', [TenderController::class, 'export'])
    ->name('tenders.export')
    ->where('format', 'excel|pdf');

Route::post('/tenders/{id}/stop', [TenderController::class, 'stopTender'])->name('stopTender')->middleware(['permission:tender.stop']);

Route::get('/tenders/{id}/qrcode', [TenderController::class, 'generateQrCode'])->name('tenders.qrcode');

Route::get('/tenders/{id}/download', [TenderController::class, 'download'])->name('tenders.download');

Route::resource('Admintenders', AdminTenderController::class);

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
