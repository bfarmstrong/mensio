<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Clinic;
use Illuminate\Support\Facades\URL;
use Config;

class ClinicSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$url = parse_url(URL::current());
		$domain = explode('.', $url['host']);
		$subdomain = $domain[0];
		$subdomain = Clinic::where('subdomain', $subdomain)->first();
		$maindomain = 0;
		$exploddomain = explode('//', Config::get('app.url'));
		if($url['host'] == $exploddomain[1]){
			$maindomain = 1;
		}
	
		if (!empty($subdomain) || ($maindomain ==1) ) {
			if(!empty($subdomain)) {
				Config::set('subdomain', $subdomain->subdomain);
			}
			return $next($request);
		} else {
			return response()->view('errors.404', [], 404);
		}
        
    }
}