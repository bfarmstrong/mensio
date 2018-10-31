<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Impl\IUserService;
use App\Services\Criteria\General\WhereNotEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\User\WhereClient;
use App\Services\Impl\IClinicService;
use App\Http\Requests\Admin\AssignClinicRequest;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WhereCurrentUserClinic;
use App\Services\Criteria\User\WhereNotAssignedClinic;

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
        $clinic = $this->clinicservice->find($clinic);

        if (request()->user()->isSuperAdmin()) {
            $users = $this->user
                ->pushCriteria(new WhereNotEqual('id', request()->user()->id))
                ->pushCriteria(new WhereRelationEqual('role', 'level', 4))
                ->pushCriteria(new WhereRelationEqual('clinics', 'clinics.id', $clinic->id))
                ->paginate();
        } else {
            $users = $this->user
                ->pushCriteria(new WhereNotEqual('id', request()->user()->id))
                ->pushCriteria(new WhereRelationEqual('clinics', 'clinics.id', $clinic->id))
                ->paginate();
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
		$clients = $this->user
			->getByCriteria(new WhereNotAssignedClinic($clinic))
            ->paginate();
        $clinic = $this->clinicservice->find($clinic);

        return view('admin.clinics.assignclinics.create')->with([
            'clinic' => $clinic,
			'clients' =>$clients
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
		$this->user->assignClinic($request->clinic_id,$request->user_id);

		return redirect("admin/clinics/$request->clinic_id/assignclinic")->with([
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
    public function destroy(string $id,Request $request)
    {

		$user =  $this->user->find($id);
		$this->user->removeClinic($request->clinic_id,$user->id);

		return redirect("admin/clinics/$request->clinic_id/assignclinic")->with([
			'message' => __('admin.clinics.assignclinic.deleted-user-clinic'),
		]);

    }

	/**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request,string $clinic)
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