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

    public function updateSignature($id, $data);

    public function addPatient($patient, $user);

    public function removePatient($patient, $user);

    public function compareSignature($therapist, array $signature);

    public function verifyTherapist($therapist, string $client);

    public function invite(array $attributes);

    public function switchBack();

    public function switchToUser(string $id);

    public function findSupervisor($patient, $therapist);

    public function updateSupervisor($patient, $therapist, $supervisor);

	public function removeGroup($group, $user);

	public function removeClinic($clinic, $user);

	public function assignClinic($clinic, $user);
}
