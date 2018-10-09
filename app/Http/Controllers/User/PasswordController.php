<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordUpdateRequest;
use Auth;
use Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Controller responsible for allowing a user to update their password.
 */
class PasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * The path that the controller redirects to when the password is updated.
     *
     * @var string
     */
    protected $redirectPath = '/user/password';

    /**
     * Display the form for a user to change their password.
     *
     * @return Response
     */
    public function edit(Request $request)
    {
        return view('user.password')->with([
            'user' => $request->user(),
        ]);
    }

    /**
     * Change the user's password and return.
     *
     * @param PasswordUpdateRequest $request
     *
     * @return Response
     */
    public function update(PasswordUpdateRequest $request)
    {
        if (Hash::check($request->get('old_password'), Auth::user()->password)) {
            $this->resetPassword(Auth::user(), $request->get('new_password'));

            return redirect('user/settings')->with([
                'message' => __('user.password.password-updated'),
            ]);
        }

        return back()->withErrors([__('user.password.password-incorrect')]);
    }
}
