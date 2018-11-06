<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use App\Models\User;
use Auth;
use Session;

/**
 * Implementation of the Clinic service.
 */
class ClinicService extends BaseService implements IClinicService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Clinic::class;
    }
	
	/**
     * Switches to the specified clinic.
     *
     * @param string $id
     *
     * @return void
     */
    public function switchToClinic(string $id,string $clinic_id)
    {
        $user = User::find($id);
		Auth::login($user);
        Session::put('original_clinic', $clinic_id);
    }
	
	/**
     * Switches back to the original clinic.
     *
     * @return void
    */
    public function switchBackClinic()
    {
        $original = Session::pull('original_clinic');
        $clinic = $this->find($original);
		$user = User::find(Auth::id());
        Auth::login($user);
		return $clinic->subdomain;
    }
}
