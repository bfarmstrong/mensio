<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IUserService;
use App\Http\Requests\Admin\CreateClinicRequest;
use App\Http\Requests\Admin\UpdateClinicRequest;
use Illuminate\Http\Request;
/**
 * Handles actions related to clinic.
 */
class ClinicController extends Controller
{

    /**
     * Creates an instance of `IClinicService`.
     *
     * @param IClinicService $userService
     *
     */
    public function __construct(IClinicService $clinicservice,IUserService $user) {

		$this->clinicservice = $clinicservice;
		$this->user = $user;
    }

	/**
     * Displays the page with the list of clinic.
     *
     * @param string $group
     *
     * @return Response
    */
    public function index()
    {
		if (request()->user()->isSuperAdmin()) {
			$clinics = $this->clinicservice->paginate();
		} else {
			$clinics = request()->user()->clinics()->paginate();
        }

		return view('admin.clinics.index')->with([
            'clinics' => $clinics,
        ]);
    }

    /**
     * Displays the page to create a new clinic.
     *
     * @param string $group
     *
     * @return Response
     */
    public function create()
    {
		$this->authorize('create', Clinic::class);
        return view('admin.clinics.create');
    }
    /**
     * Creates a new clinic attached to a group.
     *
     * @param CreateClinicRequest $request
     *
     * @return Response
     */
    public function store(CreateClinicRequest $request)
    {
		$this->authorize('create', Clinic::class);
        $this->clinicservice->create($request->all());
        return redirect('admin/clinics')->with([
            'message' => __('admin.clinics.index.created-clinics'),
        ]);
    }
    /**
     * Displays the page with the details for a specific clinic.
     *
     * @param string $group
     * @param string $note
     *
     * @return Response
     */
    public function edit(string $clinic)
    {
        $clinic = $this->clinicservice->findBy('uuid', $clinic);
		$this->authorize('update', $clinic);
        return view('admin.clinics.edit')->with([
            'clinic' => $clinic,
        ]);
    }

    /**
     * Updates a clinic attached to a user.
     *
     * @param UpdateClinicRequest $request
     *
     * @return Response
     */
    public function update(UpdateClinicRequest $request,string $clinic)
    {
		$clinic = $this->clinicservice->findBy('uuid', $clinic);
		$this->authorize('update', $clinic);
        $this->clinicservice->update($clinic, $request->all());

        return back()->with([
            'message' => __('admin.clinics.index.updated-clinic'),
        ]);

    }

	/**
     * Deletes a clinic in the database.
     *
     * @param string $clinic
     *
     * @return Response
     */
    public function destroy(string $clinic)
    {
        $clinic = $this->clinicservice->findBy('uuid', $clinic);
		$this->authorize('destroy', $clinic);
        $this->clinicservice->delete($clinic);

        return redirect('admin/clinics')->with([
            'message' => __('admin.clinics.index.deleted-clinic'),
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
            return redirect('admin/clinics');
        }

        $clinics = $this->clinicservice->search($request->search);

        return view('admin.clinics.index')->with([
            'clinics' => $clinics,
        ]);
    }
}
