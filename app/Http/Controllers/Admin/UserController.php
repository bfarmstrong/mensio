<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInviteRequest;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IRoleService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manages administrative actions against users.
 */
class UserController extends Controller
{
    /**
     * The role service implementation.
     *
     * @var IRoleService
     */
    protected $roleService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `UserController`.
     *
     * @param IRoleService $roleService
     * @param IUserService $userService
     */
    public function __construct(
        IRoleService $roleService,
        IUserService $userService
    ) {
        $this->roleService = $roleService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = $this->userService->getByCriteria(new WithRole())->paginate();

        return view('admin.users.index')->with([
            'users' => $users,
        ]);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request)
    {
        if (! $request->search) {
            return redirect('admin/users');
        }

        $users = $this->userService->getByCriteria(new WithRole())->search($request->search);

        if ($users->isNotEmpty()) {
            if (1 === $users->count()) {
                $user = $users->first();

                return redirect("admin/users/$user->id");
            }

            return view('admin.users.index')->with([
                'users' => $users,
            ]);
        }

        return redirect()->back()->withErrors([
            __('admin.users.index.no-search-results'),
        ]);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return Response
     */
    public function getInvite()
    {
        $roles = $this->roleService->all();

        return view('admin.users.invite', [
            'roles' => $roles,
        ]);
    }

    /**
     * Creates a new user in the database.  Sends them a welcome email.
     *
     * @return Response
     */
    public function postInvite(UserInviteRequest $request)
    {
        $this->userService->invite($request->except(['_token', '_method']));

        return redirect('admin/users')->with([
            'message' => __('admin.users.index.created-user'),
        ]);
    }

    /**
     * Switch to a different User profile.
     *
     * @param string $id
     *
     * @return Response
     */
    public function switchToUser(string $id)
    {
        $user = $this->userService->find($id);
        $this->userService->switchToUser($id);

        return redirect('dashboard')->with([
            'message' => __('admin.users.index.switched-to', [
                'user' => $user->name,
            ]),
        ]);
    }

    /**
     * Switch back to your original user.
     *
     * @return Response
     */
    public function switchUserBack()
    {
        $this->userService->switchBack();

        return redirect('admin/dashboard')->with([
            'message' => __('admin.users.index.switched-back'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit(string $id)
    {
        $user = $this->userService->getByCriteria(new WithRole())->find($id);

        if (is_null($user)) {
            abort(404);
        }
        $roles = $this->roleService->all();

        return view('admin.users.edit')->with([
            'roles' => $roles,
            'user' => $user,
        ]);
    }

    /**
     * Shows the page to view static user information.
     *
     * @param string $id
     *
     * @return Response
     */
    public function show(string $id)
    {
        $user = $this->userService->getByCriteria(new WithRole())->find($id);

        if (is_null($user)) {
            abort(404);
        }

        return view('admin.users.show')->with([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     */
    public function update(Request $request, string $id)
    {
        $this->userService->update(
            $id,
            $request->except(['_token', '_method'])
        );

        return back()->with([
            'message' => __('admin.users.index.updated-user'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id)
    {
        $this->userService->delete($id);

        return redirect('admin/users')->with([
            'message' => __('admin.users.index.deleted-user'),
        ]);
    }
}
