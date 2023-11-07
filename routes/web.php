<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\CountyProviderPaymentReportController;
use App\Http\Controllers\Apps\CountyProviderW9Controller;
use App\Http\Controllers\Apps\NotificationsController;
use App\Http\Controllers\Apps\CountyUsersController;
use App\Http\Controllers\Apps\CountyMRAC_ARACController;
use App\Http\Controllers\Apps\ActivityController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;
use App\Http\Controllers\W9_Upload_Controller ;

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

Route::get('/export/csv', [W9_Upload_Controller::class, 'exportCsv']);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        Route::resource('/user-management/users', UserManagementController::class);
        Route::middleware(['permission:read provider payment'])->group(function () {
            Route::resource('/user-management/roles', RoleManagementController::class);
        });
        Route::resource('/user-management/permissions', PermissionManagementController::class);
    });

    Route::middleware(['permission:read provider payment'])->group(function () {
        Route::prefix('county-provider-payment-report')->name('county-provider-payment-report.')->group(function () {
            Route::get('/', [CountyProviderPaymentReportController::class,'index'])->name('index');
            
        });
    });

    Route::middleware(['permission:read provider w9'])->group(function () {
        Route::prefix('county-provider-w9')->name("county-provider-w9.")->group(function () {
            Route::get('/', [CountyProviderW9Controller::class,'index'])->name('index');
            
        });

        Route::prefix('dashboard')->name('dashboard.')->group(function () {
            Route::get('/w9_upload', [W9_Upload_Controller::class, 'showUploadForm'])->name('w9_upload');
            Route::post('/w9_upload', [W9_Upload_Controller::class, 'uploadFile']);
            Route::get('/downloadss/{filename}', [W9_Upload_Controller::class, 'downloadFile'])->name('w9_download');
        });
    });

    Route::middleware(['permission:read mrac_arac'])->group(function () {
        Route::prefix('county-mrac-arac')->name("county-mrac-arac.")->group(function () {
            Route::get('/', [CountyMRAC_ARACController::class,'index'])->name('index');
        });
    });

    Route::middleware(['permission:notification management'])->group(function () {
        Route::prefix('notification-management')->name('notification-management.')->group(function () {
            Route::get('/', [NotificationsController::class,'index'])->name('index');
        });
    });

    Route::middleware(['permission:activity management'])->group(function () {
        Route::prefix('activity-management')->name("activity-management.")->group(function () {
            Route::get('/', [ActivityController::class,'index'])->name('index');

        });
    });

    Route::get('/help-faq', [DashboardController::class, 'index'])->name('help-faq');




});

Route::get('/error', function () {
    abort(500);
});

Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
