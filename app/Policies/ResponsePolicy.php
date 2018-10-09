<?php

namespace App\Policies;

use App\Models\Response;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Handles authorization against response-related actions.
 */
class ResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Authorizes a user to create a response for a client.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isTherapist();
    }

    /**
     * Authorizes a user to destroy a response by a client.  Responses cannot
     * be deleted after they are completed.
     *
     * @param User     $user
     * @param Response $response
     *
     * @return bool
     */
    public function destroy(User $user, Response $response)
    {
        return
            ($user->isAdmin() || $user->isTherapist()) &&
            ! $response->complete
        ;
    }

    /**
     * Authorize a user to view a response list.
     *
     * @param User $user
     *
     * @return bool
     */
    public function index(User $user)
    {
        return $user->isClient();
    }

    /**
     * Authorizes a user to submit answers for a response.
     *
     * @param User     $user
     * @param Response $response
     *
     * @return bool
     */
    public function submit(User $user, Response $response)
    {
        return $response->user_id === $user->id;
    }
}
