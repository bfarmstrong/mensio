<?php

namespace App\Presenters;

use Countries;

/**
 * Functionality to display user data in views.
 */
trait UserPresenter
{
    /**
     * Returns the full name of the user's country.
     *
     * @return mixed
     */
    public function countryFull()
    {
        $country = Countries::where('cca3', $this->country)->first();

        if ($country->isNotEmpty()) {
            return $country->get('name.common');
        }

        return null;
    }

    /**
     * Returns the full name of the user's province.
     *
     * @return mixed
     */
    public function provinceFull()
    {
        $country = Countries::where('cca3', $this->country)->first();

        if ($country->isNotEmpty()) {
            $province = $country
                ->hydrateStates()
                ->states
                ->where('postal', $this->province)
                ->first();

            if ($province->isNotEmpty()) {
                return $province->get('name');
            }

            return null;
        }

        return null;
    }

    /**
     * Returns the full-text version of the user preferred contact method.
     *
     * @return string
     */
    public function preferredContactMethod()
    {
        switch ($this->preferred_contact_method) {
            case 'EM':
                return __('user.presenter.email');
            default:
                return __('user.presenter.phone');
        }
    }

    /**
     * Returns the name of the role of the user.
     *
     * @return string
     */
    public function roleName()
    {
		$rolesnames = [];
        if ($this->isClient()) {
            array_push($rolesnames, __('user.presenter.client'));
        } 
		if ($this->isTherapist()) {
			array_push($rolesnames,__('user.presenter.therapist'));
        } 
		if ($this->isAdmin()) {
			array_push($rolesnames,__('user.presenter.admin'));
		}
	   return $rolesnames;
    }
	
	/**
     * Returns the name of the role of the clinic assigned user.
     *
     * @return string
     */
    public function assignClinicRoleName()
    { 
	   return implode(',',$this->roles()->wherePivot('clinic_id', '=',request()->segment(3))->pluck('label')->toArray());
    }
}
