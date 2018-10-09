<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Services\Impl\IUserService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Controller responsible for allowing a user to update their own profile.
 */
class SettingsController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `SettingsController`.
     *
     * @param IUserService $userService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Shows the form for a user to view and edit their settings.
     *
     * @return Response
     */
    public function edit(Request $request)
    {
        return view('user.settings')->with([
            'user' => $request->user(),
        ]);
    }

    /**
     * Updates the user's profile with new values.
     *
     * @param UpdateAccountRequest $request
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request)
    {
        $this->userService->update(auth()->id(), $request->all());

        return back()->with([
            'message' => __('user.settings.profile-updated'),
        ]);
    }
}
