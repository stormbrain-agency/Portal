<?php
use App\Http\Controllers\Apps\PermissionManagementController;
use App\Http\Controllers\Apps\RoleManagementController;
use App\Http\Controllers\Apps\UserManagementController;
use App\Http\Controllers\Apps\PaymentReportController;
use App\Http\Controllers\Apps\CountyProviderW9Controller;
use App\Http\Controllers\Apps\NotificationsController;
use App\Http\Controllers\Apps\NotificationMailController;
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

Route::middleware(['phone_verify'])->group(function () {
    Route::middleware(['auth', 'verified', 'check_status'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/get-counties/{stateId}', 'LocationController@getCountiesByState');
        Route::get('/profile', [UserManagementController::class, 'profile'])->name('profile');
        Route::get('/state', [LocationController::class, 'getStates'])->name('state');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::name('user-management.')->group(function () {
            Route::middleware(['permission:edit users management'])->group(function () {
                Route::resource('/user-management/users', UserManagementController::class);
            });
            Route::middleware(['permission:county users management'])->group(function () {
                Route::prefix('/user-management/county-users')->name('county-users.')->group(function () {
                    Route::get('/', [UserManagementController::class,'county_users'])->name('index');
                    Route::get('/user/{id}', [UserManagementController::class,'usersCountyShow'])->name('show');
                    Route::get('/user/approve/{id}', [UserManagementController::class,'usersPendingApprove'])->name('approve');
                    Route::get('/user/deny/{id}', [UserManagementController::class,'usersPendingDeny'])->name('deny');
                    Route::delete('/user/{user}/destroy', [UserManagementController::class, 'destroyCounty'])->name('destroy');
                });
            });
            Route::resource('/user-management/roles', RoleManagementController::class);
        Route::resource('/user-management/permissions', PermissionManagementController::class);
        });
        Route::middleware(['permission:read provider payment'])->group(function () {
            Route::prefix('county-provider-payment-report')->name('county-provider-payment-report.')->group(function () {
                Route::get('/', [PaymentReportController::class,'index'])->name('index');
                Route::get('/csv', [PaymentReportController::class, 'csv'])->name('csv');
                Route::middleware(['permission:create provider payment'])->group(function () {
                    Route::post('/create', [PaymentReportController::class,'store'])->name('store');
                    Route::get('/create', [PaymentReportController::class,'create'])->name('create');
                });
                Route::get('/template/download', [PaymentReportController::class, 'downloadTemplate'])->name('download_template');
                Route::get('/downloads/{filename}', [PaymentReportController::class, 'downloadFile'])->name('download');
                Route::get('/downloads/{filename}/{payment_id}', [PaymentReportController::class, 'downloadFile'])->name('download2');
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
                Route::middleware(['permission:create mrac_arac'])->group(function () {
                    Route::post('/create', [CountyMRAC_ARACController::class,'store'])->name('store');
                    Route::get('/create', [CountyMRAC_ARACController::class,'create'])->name('create');
                });
                Route::get('/template/download', [CountyMRAC_ARACController::class, 'downloadTemplate'])->name('download_template');
                Route::get('/downloads/{filename}', [CountyMRAC_ARACController::class, 'downloadFile'])->name('download');
                Route::get('/downloads/{filename}/{payment_id}', [CountyMRAC_ARACController::class, 'downloadFile2'])->name('download2');
                Route::get('/download-all-files/{payment_id}', [CountyMRAC_ARACController::class, 'downloadAllFiles'])->name('downloadAllFiles');
            });
        });
        Route::name('notification-management.')->group(function () {
            Route::middleware(['permission:notification management'])->group(function () {
                Route::prefix('/notification-management/dashboard')->name('dashboard.')->group(function () {
                    Route::get('/', [NotificationsController::class,'index'])->name('index');
                    Route::get('/create', [NotificationsController::class, 'create'])->name('create');
                    Route::post('/store', [NotificationsController::class, 'store'])->name('store');
                    Route::get('/edit/{id}', [NotificationsController::class, 'edit'])->name('edit');
                    Route::put('/update/{id}', [NotificationsController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [NotificationsController::class, 'delete'])->name('delete');
                    Route::post('/update-status', [NotificationsController::class, 'updateStatus'])->name('update-status');
                });
            });
            Route::middleware(['permission:notification management'])->group(function () {
                Route::prefix('/notification-management/email')->name('email.')->group(function () {
                    Route::get('/', [NotificationMailController::class,'index'])->name('index');
                    Route::get('/create', [NotificationMailController::class, 'create'])->name('create');
                    Route::post('/store', [NotificationMailController::class, 'store'])->name('store');
                    Route::get('/edit/{id}', [NotificationMailController::class, 'edit'])->name('edit');
                    Route::put('/update/{id}', [NotificationMailController::class, 'update'])->name('update');
                    Route::delete('/delete/{id}', [NotificationMailController::class, 'delete'])->name('delete');
                });
            });
        });
        Route::middleware(['permission:activity management'])->group(function () {
            Route::prefix('activity-management')->name("activity-management.")->group(function () {
                Route::get('/', [ActivityController::class,'index'])->name('index');
                Route::get('/users/{user_id}', [ActivityController::class, 'show'])->name('show');
            });
        });
        Route::get('/help-faq', [DashboardController::class, 'index'])->name('help-faq');
    });

    Route::get('/help-faq', [Help_FAQController::class, 'index'])->name('help-faq');

});
Route::get('/error', function () {
    abort(500);
});
Route::get('/get-counties/{stateId}', [LocationController::class, 'getCountiesByState']);
Route::get('/auth/redirect/{provider}', [SocialiteController::class, 'redirect']);
require __DIR__ . '/auth.php';
