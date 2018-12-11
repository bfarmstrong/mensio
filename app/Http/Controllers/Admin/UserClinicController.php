<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AssignClinicRequest;
use App\Services\Criteria\General\WhereNotEqual;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WithRole;
use App\Services\Criteria\User\WhereCurrentUserClinic;
use App\Services\Criteria\User\WhereNotAssignedClinic;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IUserService;
use App\Services\Impl\IRoleService;
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
    /**
     * The role service implementation.
     *
     * @var IRoleService
     */
    protected $roleService;
	
    public function __construct(
        IUserService $user,
        IClinicService $clinicservice,
		IRoleService $roleService
    ) {
        $this->user = $user;
        $this->clinicservice = $clinicservice;
		$this->roleService = $roleService;
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
                ->pushCriteria(new WhereRelationEqual('roles', 'level', 4))
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
		if (!request()->user()->isSuperAdmin()) {
			$clients = $this->user
				->getByCriteria(new WhereNotAssignedClinic($clinic))
				->all();
		} else { 
		    $clients = $this->user
				->all();
		}
        $clinic = $this->clinicservice->find($clinic);

        return view('admin.clinics.assignclinics.create')->with([
            'clinic' => $clinic,
            'clients' =>$clients,
        ]);
    }

    /**
     * Assign a new clinic  to a users.
     *
     * @param UserClinicController $request
     *
     * @return Response
     */
    public function store(AssignClinicRequest $request)
    {	
		
		$this->user->assignClinic($request->clinic_id, $request->user_id, $request->role_id);
		
        return redirect("admin/clinics/$request->clinic_id/assignclinic")->with([
            'message' => __('admin.clinics.assignclinic.user-assigned'),
        ]);
    }
	
	/**
     * Assign a new role to a clinic.
     *
     * @param assignRoletoClinic $request
     *
     * @return Response
     */
	public function assignRoletoClinic(string $clinic_id,string $id){
			$user = $this->user->getByCriteria(new WithRole())->find($id);
			if(!empty($user->roles()->pluck('label','roles.id')->toArray())){
				$html  = '<div class="form-row">
								<div class="form-group col-12">
									<label for="role_id">Roles</label>
									<select class="form-control" name="role_id[]" multiple="multiple">';
				
				foreach($user->roles()->pluck('label','roles.id')->toArray() as $key => $roles){
					$html .='<option value="'.$key.'">'.$roles.'</option>';
				}
				$html .= '</select>
								</div>
						</div>';
			} else {
			
				$html  = '<div class="form-row">
							<div class="form-group col-12">
								<label for="role_id">Roles</label>
								<select class="form-control" name="role_id[]" multiple="multiple">';
				
				foreach($this->roleService->all()->toArray() as $key => $roles){
					$html .='<option value="'.$roles['id'].'">'.$roles['label'].'</option>';
				}
				$html .= '</select>
								</div>
						</div>';
			}
		return  $html;
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
        $this->user->removeClinic($request->clinic_id, $user->id);

        return redirect("admin/clinics/$request->clinic_id/assignclinic")->with([
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
