<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\RegisteredNotificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Livewire\TwoFA\PhoneNumberVerify ;
use Illuminate\Support\Facades\Route;



Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
            ->name('password.request');

Route::post('forgot-password', [PasswordResetLinkController::class, 'sendResetLinkEmail'])
            ->name('password.email');

Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
            ->name('password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']); 
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
            ->name('verification.verify');
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::get('/logout', function () {
            Auth::logout(); 
            return redirect('/login'); 
        })->name('logout_to_login');

    Route::prefix('/verify')->group(function () {
        Route::get('/phone', function () { 
            return view('pages.auth.verify-phone');
        })->name('verify.phone');
    });

    Route::get('rejected', [RegisteredUserController::class, 'rejected'])
            ->name('rejected');
    Route::get('censoring', [RegisteredUserController::class, 'censoring'])
            ->name('censoring');
    Route::get('confirm_email', [RegisteredUserController::class, 'confirm_email'])
            ->name('confirm_email');
});
