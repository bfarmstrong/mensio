<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the user service.
 */
interface IUserService extends IBaseService
{
    public function addTherapist($therapist, $user);

    public function removeTherapist($therapist, $user);

    public function addPatient($patient, $user);

    public function removePatient($patient, $user);

    public function invite(array $attributes);

    public function switchBack();

    public function switchToUser(string $id);
}
