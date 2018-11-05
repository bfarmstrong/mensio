<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use User;
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
    public function switchToClinic(string $id)
    {
        $user = User::find(Auth::id());
        Session::put('original_clinic', $id);
        Auth::login($user);
    }
	
	/**
     * Switches back to the original clinic.
     *
     * @return void
    */
    public function switchBackClinic()
    {
        $original = Session::pull('original_clinic');
        $user = $this->find(Auth::id());
        Auth::login($user);
		return $original;
    }
}
