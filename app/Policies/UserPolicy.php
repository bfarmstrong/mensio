<?php

namespace App\Policies;

use App\Models\User;
use App\Services\Impl\IUserService;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Handles authorization against user-related actions.
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Authorizes a user to add a note to a client.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function addNote(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
    }

    /**
     * Authorizes a user to assign a questionnaire to a client.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function addQuestionnaire(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
    }

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
        return $user->isAdmin() && $client->isClient();
    }

    /**
     * Authorizes a user to create a new user.
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
     * Authorizes a user to delete a user from the system.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Authorizes a user to remove a questionnaire from a client.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function removeQuestionnaire(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
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
        return $user->isAdmin() && $client->isClient();
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
        return $user->isAdmin();
    }

    /**
     * Authorizes a user to update a note for a user.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function updateNote(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
    }

    /**
     * Authorizes a user to view another user.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function view(User $user, User $client)
    {
        return
            $user->isAdmin() ||
            ($this->userService->verifyTherapist($user, $client->id))
        ;
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
     * Authorizes a user to view a note created for a client.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function viewNotes(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
    }

    /**
     * Authorizes a user to view a questionnaire completed by a client.
     *
     * @param User $user
     * @param User $client
     *
     * @return bool
     */
    public function viewQuestionnaires(User $user, User $client)
    {
        return $this->userService->verifyTherapist($user, $client->id);
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
        return $user->isAdmin() && $client->isClient();
    }
}
