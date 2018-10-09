<?php

namespace App\Http\Controllers;

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
}
