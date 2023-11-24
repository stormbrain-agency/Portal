<?php

use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\PaymentReportController;
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
use App\Http\Controllers\Apps\Help_FAQController ;
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



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserManagementController::class, 'profile'])->name('profile');
    Route::get('/profile/details', [UserManagementController::class, 'profileDetails'])->name('profileDetails');
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

    });

    Route::middleware(['permission:read provider payment'])->group(function () {
        Route::prefix('county-provider-payment-report')->name('county-provider-payment-report.')->group(function () {
            Route::get('/', [PaymentReportController::class,'index'])->name('index');
            Route::get('/csv', [PaymentReportController::class, 'csv'])->name('csv');
            Route::middleware(['permission:create provider payment'])->group(function () {
                Route::post('/create', [PaymentReportController::class,'store'])->name('store');
                Route::get('/create', [PaymentReportController::class,'create'])->name('create');
            });
            Route::get('/template', [PaymentReportController::class,'template'])->name('template');
            Route::post('/template', [PaymentReportController::class,'store_template'])->name('store_template');
            Route::get('/template/download', [PaymentReportController::class, 'downloadTemplateFile'])->name('download_template');
            Route::get('/downloads/{filename}', [PaymentReportController::class, 'downloadFile'])->name('download');
            Route::get('/downloads/{filename}/{payment_id}', [PaymentReportController::class, 'downloadFile'])->name('download2');
            Route::get('/download-all-files/{payment_id}', [PaymentReportController::class, 'downloadAllFiles'])->name('downloadAllFiles');
            
        });
    });

    Route::middleware(['permission:read provider w9'])->group(function () {
        Route::prefix('/county-w9')->name('w9_upload.')->group(function () {
            //view
            Route::get('/', [W9_Upload_Controller::class,'wp_upload_index'])->name('index');
            //upload
            Route::middleware(['permission:create provider w9'])->group(function () {
                Route::get('/upload', [W9_Upload_Controller::class,'upload'])->name('create');
                Route::post('/upload', [W9_Upload_Controller::class, 'uploadFile']);
            });
            //download
            Route::get('/downloadss/{w9_id}/{filename}', [W9_Upload_Controller::class, 'downloadFile'])->name('w9_download');
        });
        Route::prefix('/w9_downloadhistory')->name('w9_downloadhistory.')->group(function () {
            Route::get('/', [W9_Historydownload_Controller::class,'w9_downloadhistory_index'])->name('index');
        });
    });
    

    Route::middleware(['permission:read mrac_arac'])->group(function () {
        Route::prefix('county-mrac-arac')->name("county-mrac-arac.")->group(function () {
            Route::get('/', [CountyMRAC_ARACController::class,'index'])->name('index');

            Route::middleware(['permission:read mrac_arac'])->group(function () {
                Route::post('/create', [CountyMRAC_ARACController::class,'store'])->name('store');
                Route::get('/create', [CountyMRAC_ARACController::class,'create'])->name('create');
            });
            Route::post('/template', [CountyMRAC_ARACController::class,'store_template'])->name('store_template');
            Route::get('/template', [CountyMRAC_ARACController::class,'template'])->name('template');
            Route::get('/template/download', [CountyMRAC_ARACController::class, 'downloadTemplateFile'])->name('download_template');
            Route::get('/downloads/{filename}', [CountyMRAC_ARACController::class, 'downloadFile'])->name('download');
            Route::get('/downloads/{filename}/{payment_id}', [CountyMRAC_ARACController::class, 'downloadFile2'])->name('download2');
            Route::get('/download-all-files/{payment_id}', [CountyMRAC_ARACController::class, 'downloadAllFiles'])->name('downloadAllFiles');
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

    Route::get('/help-faq', [Help_FAQController::class, 'index'])->name('help-faq');

});

Route::get('/error', function () {
    abort(500);
});
Route::get('/get-counties/{stateId}', [LocationController::class, 'getCountiesByState']);
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);

Route::get('/verify-login', function () {
    return view('pages.auth.verify-login');
});
require __DIR__ . '/auth.php';
