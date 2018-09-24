<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Handles authorization against user-related actions.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Authorizes a user to add a therapist to a patient.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function addTherapist(User $user, User $client)
    {
        return $user->hasAtLeastRole('admin') && $client->isClient();
    }

    /**
     * Authorizes a user to delete a user from the system.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->hasAtLeastRole('admin');
    }

    /**
     * Authorizes a user to remove a therapist from a patient.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function removeTherapist(User $user, User $client)
    {
        return $user->hasAtLeastRole('admin') && $client->isClient();
    }

    /**
     * Authorizes a user to update another user.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->hasAtLeastRole('admin');
    }

    /**
     * Authorizes a user to view their list of clients.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewClients(User $user)
    {
        return $user->isTherapist();
    }

    /**
     * Authorizes a user to view the list of therapists.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function viewTherapists(User $user, User $client)
    {
        return $user->hasAtLeastRole('admin') && $client->isClient();
    }
}
