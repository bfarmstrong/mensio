<?php

namespace App\Policies;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Facilitates authorization against the doctor resource.
 */
class DoctorPolicy
{
    use HandlesAuthorization;

    /**
     * Returns if a user is allowed to create a doctor.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Returns if a user is allowed to delete a doctor.
     *
     * @param User   $user
     * @param Doctor $doctor
     *
     * @return bool
     */
    public function destroy(User $user, Doctor $doctor)
    {
        return $user->isAdmin();
    }

    /**
     * Returns if a user is allowed to update a doctor.
     *
     * @param User   $user
     * @param Doctor $doctor
     *
     * @return bool
     */
    public function update(User $user, Doctor $doctor)
    {
        return $user->isAdmin();
    }
}
