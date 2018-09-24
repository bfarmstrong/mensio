<?php

namespace App\Presenters;

/**
 * Functionality to display user data in views.
 */
trait UserPresenter
{
    /**
     * Returns the name of the role of the user.
     *
     * @return string
     */
    public function roleName()
    {
        if ($this->isClient()) {
            return __('user.presenter.client');
        } elseif ($this->isTherapist()) {
            return __('user.presenter.therapist');
        }

        return __('user.presenter.admin');
    }
}
