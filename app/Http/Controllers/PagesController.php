<?php

namespace App\Http\Controllers;
use Notification;
use App\Notifications\ConsentEmail;

class PagesController extends Controller
{
    /**
     * Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return redirect('dashboard');
    }

    /**
     * Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (auth()->user()->isAdmin()) {
            return redirect('admin/dashboard');
        }

        return view('dashboard');
    }
	public function checkconsent()
	{
		if (\Auth::user()->first_time_login == 0) {
			\Auth::user()->first_time_login = 1; 
			\Auth::user()->save();
			Notification::send(\Auth::user(), new ConsentEmail($password));
		}
	}
}
