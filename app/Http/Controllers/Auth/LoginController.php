<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide this functionality to your appliations.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Check user's role and redirect user based on their role.
     *
     * @return
     */
    public function authenticated()
    { 
        if (auth()->user()->isAdmin()) {
            return redirect('/admin/dashboard');
         } /* elseif(auth()->user()->isClient()) {
			\Auth::logout();
			return redirect('/login')->with('message', __('auth.login.temporary_failed'));
		} else { */
		    return redirect('dashboard');
		//}
    }
}
