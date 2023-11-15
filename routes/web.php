<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\CountyProviderPaymentReportController;
use App\Http\Controllers\Apps\CountyProviderW9Controller;
use App\Http\Controllers\Apps\NotificationsController;
use App\Http\Controllers\Apps\CountyUsersController;
use App\Http\Controllers\Apps\CountyMRAC_ARACController;
use App\Http\Controllers\Apps\LocationController;
use App\Http\Controllers\Apps\ActivityController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Apps\W9_Upload_Controller ;
use App\Http\Controllers\Apps\W9_Historydownload_Controller ;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckPermission;

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

Route::get('/downloads', [W9_Historydownload_Controller::class, 'showDownloads'])->name('downloads');
// Route::get('password/request', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// Route::get('password/reset/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.reset');
Route::get('/export/csv', [W9_Upload_Controller::class, 'exportCsv']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserManagementController::class, 'profile'])->name('profile');
    // Route::get('/', [DashboardController::class, 'index']);
    Route::get('/get-counties/{stateId}', 'LocationController@getCountiesByState');

    Route::get('/profile', [UserManagementController::class, 'profile'])->name('profile');
    Route::get('/state', [LocationController::class, 'getStates'])->name('state');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard', [W9_Upload_Controller::class, 'showUploadForm'])->name('dashboard');

    Route::name('user-management.')->group(function () {
        // Route::middleware(['permission:county users management'])->group(function () {
            Route::resource('/user-management/users', UserManagementController::class);
        // });
        Route::middleware(['permission:county users management'])->group(function () {
            Route::prefix('/user-management/user-pending')->name('users-pending.')->group(function () {
                Route::get('/', [UserManagementController::class,'users_pending'])->name('index');
                Route::get('/users/{id}', [UserManagementController::class,'usersPendingShow'])->name('show');
                Route::get('/users/approve/{id}', [UserManagementController::class,'usersPendingApprove'])->name('approve');
                Route::get('/users/deny/{id}', [UserManagementController::class,'usersPendingDeny'])->name('deny');
                
            });
        });
        // Route::middleware(['permission:county users management'])->group(function () {
        //     Route::resource('/user-management/roles', RoleManagementController::class);
        //     Route::resource('/user-management/permissions', PermissionManagementController::class);
        // });
    });

    Route::middleware(['permission:read provider payment'])->group(function () {
        Route::prefix('county-provider-payment-report')->name('county-provider-payment-report.')->group(function () {
            Route::get('/', [CountyProviderPaymentReportController::class,'index'])->name('index');
            
        });
    });

    Route::middleware(['permission:read provider w9'])->group(function () {
        Route::prefix('/w9_upload')->name('w9_upload.')->group(function () {
            // Route::get('/export', [W9_Upload_Controller::class, 'export'])->name('w9_upload.export');
            Route::get('/filter', 'Apps\W9_Upload_Controller@filter')->name('filter');
            Route::get('/', [W9_Upload_Controller::class,'wp_upload_index'])->name('index');
            Route::post('/w9_upload', [W9_Upload_Controller::class, 'uploadFile']);
            Route::get('/downloadss/{filename}', [W9_Upload_Controller::class, 'downloadFile'])->name('w9_download');
        });
        Route::prefix('/w9_downloadhistory')->name('w9_downloadhistory.')->group(function () {
            Route::get('/', [W9_Historydownload_Controller::class,'w9_downloadhistory_index'])->name('index');
        });

        // Route::prefix('county-provider-w9')->name("county-provider-w9.")->group(function () {
        //     Route::get('/w9_upload', [W9_Upload_Controller::class, 'showUploadForm'])->name('w9_upload');
        //     Route::post('/w9_upload', [W9_Upload_Controller::class, 'uploadFile']);
        //     Route::get('/downloadss/{filename}', [W9_Upload_Controller::class, 'downloadFile'])->name('w9_download');
        // });
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
Route::get('/get-counties/{stateId}', [LocationController::class, 'getCountiesByState']);
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

require __DIR__ . '/auth.php';
