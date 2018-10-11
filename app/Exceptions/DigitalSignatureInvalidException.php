<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception that is thrown when a digital signature is not valid after it
 * is compared.
 */
class DigitalSignatureInvalidException extends Exception
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
            ->withInput()
            ->withErrors([
                __('exceptions.DigitalSignatureInvalidException.message'),
            ]);
    }
}
