<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception that occurs when a questionnaire has already been assigned to a
 * client and a therapist attempts to do so again.
 */
class QuestionnaireAlreadyAssignedException extends Exception
{
    /**
     * Renders the error.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function render()
    {
        return redirect()
            ->back()
            ->withErrors([
                __('exceptions.QuestionnaireAlreadyAssignedException.message'),
            ]);
    }
}
