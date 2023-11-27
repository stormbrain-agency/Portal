<?php

namespace App\Providers;
use Livewire\Livewire;
use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Update defaultStringLength
        Builder::defaultStringLength(191);

        Livewire::component('mrac_arac.view-mrac-arac', \App\Http\Livewire\MracArac\ViewMracArac::class);

        Livewire::component('2fa.phone-number-verify', \App\Http\Livewire\TwoFA\PhoneNumberVerify::class);

        KTBootstrap::init();
    }
}
