<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider; //Import Schema

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Response::observe(\App\Observers\ResponseObserver::class);
        Schema::defaultStringLength(191); //Solved by increasing StringLength
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
