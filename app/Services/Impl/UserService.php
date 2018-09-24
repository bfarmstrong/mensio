<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the user service.
 */
class UserService extends BaseService implements IUserService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\User::class;
    }

    /**
     * Adds a patient to a user.
     *
     * @param mixed $patient
     * @param mixed $user
     *
     * @return void
     */
    public function addPatient($patient, $user)
    {
        $user = $this->find($user);
        $user->patients()->attach($patient);
    }

    /**
     * Removes a patient from a user.
     *
     * @param mixed $patient
     * @param mixed $user
     *
     * @return void
     */
    public function removePatient($patient, $user)
    {
        $user = $this->find($user);
        $user->patients()->detach($patient);
    }

    /**
     * Adds a therapist to a user.
     *
     * @param mixed $therapist
     * @param mixed $user
     *
     * @return void
     */
    public function addTherapist($therapist, $user)
    {
        $user = $this->find($user);
        $user->therapists()->attach($therapist);
    }

    /**
     * Removes a therapist from a user.
     *
     * @param mixed $therapist
     * @param mixed $user
     *
     * @return void
     */
    public function removeTherapist($therapist, $user)
    {
        $user = $this->find($user);
        $user->therapists()->detach($therapist);
    }
}
