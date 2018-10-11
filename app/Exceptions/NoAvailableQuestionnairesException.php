<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception that occurs when there are no questionnaires available to be
 * assigned to a client.
 */
class NoAvailableQuestionnairesException extends Exception
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
                __('exceptions.NoAvailableQuestionnairesException.message'),
            ]);
    }
}
