<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleCreateRequest;
use App\Services\Impl\IRoleService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Manages administrative actions against roles.
 */
class RoleController extends Controller
{
    /**
     * The service implementation for roles.
     *
     * @var IRoleService
     */
    protected $service;

    /**
     * Creates an instance of `RoleController`.
     *
     * @param IRoleService $service
     */
    public function __construct(IRoleService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->service->paginate();

        return view('admin.roles.index')->with([
            'roles' => $roles,
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
            return redirect('admin/roles');
        }

        $roles = $this->service->search($request->search);

        return view('admin.roles.index')->with([
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a role.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return Response
     */
    public function store(RoleCreateRequest $request)
    {
        $this->service->create($request->except(['_token', '_method']));

        return redirect('admin/roles')->with([
            'message' => __('admin.roles.index.created-role'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function edit(string $uuid)
    {
        $role = $this->service->findBy('uuid', $uuid);

        if (is_null($role)) {
            abort(404);
        }

        return view('admin.roles.edit')->with([
            'role' => $role,
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
    public function update(Request $request, string $uuid)
    {
        $role = $this->service->findBy('uuid', $uuid);

        if (is_null($role)) {
            abort(404);
        }

        $this->service->update(
            $role->id,
            $request->except(['_token', '_method'])
        );

        return back()->with([
            'message' => __('admin.roles.index.updated-role'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function destroy(string $uuid)
    {
        $role = $this->service->findBy('uuid', $uuid);

        if (is_null($role)) {
            abort(404);
        }

        $this->service->delete($role->id);

        return redirect('admin/roles')->with([
            'message' => __('admin.roles.index.deleted-role'),
        ]);
    }
}
