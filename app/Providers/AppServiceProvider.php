<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; //Import Schema
use App\Models\Clinic;
use Illuminate\Support\Facades\URL;
use Config;
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
		$url = parse_url(URL::current());
		$domain = explode('.', $url['host']);
		$subdomain = $domain[0];
		$subdomain = Clinic::where('subdomain', $subdomain)->first();
		if (!empty($subdomain)) {
			Config::set('subdomain', $subdomain->subdomain);
		}
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
