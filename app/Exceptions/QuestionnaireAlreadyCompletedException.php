<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception that occurs when a questionnaire is already completed by the user
 * and an unauthorized action is being made against the response.
 */
class QuestionnaireAlreadyCompletedException extends Exception
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
                __('exceptions.QuestionnaireAlreadyCompletedException.message'),
            ]);
    }
}
