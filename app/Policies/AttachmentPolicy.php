<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Facilitates authorization against the attachment resource.
 */
class AttachmentPolicy
{
    use HandlesAuthorization;

    /**
     * Returns whether a user is allowed to create an attachment.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->isTherapist() || $user->isAdmin();
    }

    /**
     * Returns whether a user is allowed to view attachments.
     *
     * @param User $user
     *
     * @return bool
     */
    public function view(User $user)
    {
        return $user->isTherapist() || $user->isAdmin();
    }
}
