<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignClinicRequest;
use App\Services\Criteria\General\WhereNotEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WhereCurrentUserClinic;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;

/**
 * Handles actions related to notes against a group.
 */
class UserClinicController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;

    public function __construct(
        IUserService $user,
        IClinicService $clinicservice
    ) {
        $this->user = $user;
        $this->clinicservice = $clinicservice;
    }

    /**
     * Displays the page with the list of users for a clinic.
     *
     * @param string $clinic
     *
     * @return Response
     */
    public function index(string $clinic)
    {
        $clinic = $this->clinicservice->findBy('uuid', $clinic);

        if (request()->user()->isSuperAdmin()) {
            $users = $this->user
                ->pushCriteria(new WhereNotEqual('id', request()->user()->id))
                ->pushCriteria(new WhereRelationEqual('role', 'level', 4))
                ->pushCriteria(new WhereRelationEqual('clinics', 'clinics.id', $clinic->id))
                ->all();
        } else {
            $users = $this->user
                ->pushCriteria(new WhereNotEqual('id', request()->user()->id))
                ->pushCriteria(new WhereRelationEqual('clinics', 'clinics.id', $clinic->id))
                ->all();
        }

        return view('admin.clinics.assignclinics.index')->with([
                'users' => $users,
                'clinic' => $clinic,
            ]);
    }

    /**
     * Displays the page to assing a new clinic.
     *
     * @param string $clinic
     *
     * @return Response
     */
    public function create(string $clinic)
    {
        $users = $this->user
            ->pushCriteria(
                new WhereRelationEqual(
                    'role',
                    'roles.level',
                    Roles::Administrator
                )
            )
            ->pushCriteria(new WithRelation('clinics'))
            ->all();
        $clinic = $this->clinicservice->findBy('uuid', $clinic);

        $users = $users->reject(function ($user) use ($clinic) {
            return $user->clinics->contains($clinic);
        });

        if ($users->isEmpty()) {
            return redirect()->back()->withErrors([
                __('admin.clinics.assignclinic.no-users'),
            ]);
        }

        return view('admin.clinics.assignclinics.create')->with([
            'clinic' => $clinic,
            'clients' => $users,
        ]);
    }

    /**
     * Creates a new note attached to a group.
     *
     * @param CreateGroupNoteRequest $request
     *
     * @return Response
     */
    public function store(AssignClinicRequest $request)
    {
        $clinic = $this->clinicservice->find($request->clinic_id);
        $this->user->assignClinic($request->clinic_id, $request->user_id);

        return redirect("admin/clinics/$clinic->uuid/assignclinic")->with([
            'message' => __('admin.clinics.assignclinic.user-assigned'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id, Request $request)
    {
        $user = $this->user->find($id);
        $clinic = $this->clinicservice->find($request->clinic_id);
        $this->user->removeClinic($request->clinic_id, $user->id);

        return redirect("admin/clinics/$clinic->uuid/assignclinic")->with([
            'message' => __('admin.clinics.assignclinic.deleted-user-clinic'),
        ]);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request, string $clinic)
    {
        if (! $request->search) {
            return redirect("admin/clinics/$clinic/assignclinic");
        }

        $searchString = $request->get('search');

        $users = $this->user
            ->pushCriteria(new WithRelation('clinics'))
            ->pushCriteria(new WhereCurrentUserClinic($clinic))
            ->search($request->get('search'));
        $clinic = $this->clinicservice->find($clinic);

        return view('admin.clinics.assignclinics.index')->with([
                'users' => $users,
                'clinic' => $clinic,
            ]);
    }
}
