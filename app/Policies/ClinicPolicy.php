<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Facilitates authorization against the clinic resource.
 */
class ClinicPolicy
{
    use HandlesAuthorization;

    /**
     * Returns if a user is allowed to create a clinic.
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
     * Returns if a user is allowed to delete a clinic.
     *
     * @param User   $user
     * @param Clinic $clinic
     *
     * @return bool
     */
    public function destroy(User $user, Clinic $clinic)
    {
        return $user->isAdmin();
    }

    /**
     * Returns if a user is allowed to update a clinic.
     *
     * @param User   $user
     * @param Clinic $clinic
     *
     * @return bool
     */
    public function update(User $user, Clinic $clinic)
    {
        return $user->isAdmin();
    }
}
