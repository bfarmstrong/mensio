<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IDoctorService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Administrative actions against the doctor resource in the database.
 */
class DoctorController extends Controller
{
    /**
     * Creates an instance of `DoctorController`.
     *
     * @param IDoctorService $doctorService
     */
    public function __construct(IDoctorService $doctorService)
    {
        $this->doctorService = $doctorService;
    }

    /**
     * Renders a page to create a new doctor.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Doctor::class);

        return view('admin.doctors.create');
    }

    /**
     * Renders a page to update an existing doctor.
     *
     * @param string $doctor
     *
     * @return Response
     */
    public function edit(string $doctor)
    {
        $doctor = $this->doctorService->findBy('uuid', $doctor);
        $this->authorize('update', $doctor);

        return view('admin.doctors.edit')->with([
            'doctor' => $doctor,
        ]);
    }

    /**
     * Deletes a doctor in the database.
     *
     * @param string $doctor
     *
     * @return Response
     */
    public function destroy(string $doctor)
    {
        $doctor = $this->doctorService->findBy('uuid', $doctor);
        $this->authorize('destroy', $doctor);
        $this->doctorService->delete($doctor);

        return redirect('admin/doctors')->with([
            'message' => __('admin.doctors.index.deleted-doctor'),
        ]);
    }

    /**
     * Renders a page of paginated doctors.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $doctors = $this->doctorService
            ->getByCriteria(new WhereEqual('is_default', 0))
            ->paginate();

        if ($request->wantsJson()) {
            return $doctors;
        }

        return view('admin.doctors.index')->with([
            'doctors' => $doctors,
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
            return redirect('admin/doctors');
        }

        $doctors = $this->doctorService
            ->getByCriteria(new WhereEqual('is_default', 0))
            ->search($request->search);

        if ($request->wantsJson()) {
            return $doctors;
        }

        return view('admin.doctors.index')->with([
            'doctors' => $doctors,
        ]);
    }

    /**
     * Creates a new doctor in the database.
     *
     * @param CreateDoctorRequest $request
     *
     * @return Response
     */
    public function store(CreateDoctorRequest $request)
    {
        $this->authorize('create', Doctor::class);

        $this->doctorService->create($request->all());

        return redirect('admin/doctors')->with([
            'message' => __('admin.doctors.index.created-doctor'),
        ]);
    }

    /**
     * Updates an existing doctor in the database.
     *
     * @param UpdateDoctorRequest $request
     * @param string              $doctor
     *
     * @return Response
     */
    public function update(UpdateDoctorRequest $request, string $doctor)
    {
        $doctor = $this->doctorService->findBy('uuid', $doctor);
        $this->authorize('update', $doctor);

        $this->doctorService->update($doctor, $request->all());

        return back()->with([
            'message' => __('admin.doctors.index.updated-doctor'),
        ]);
    }
}
