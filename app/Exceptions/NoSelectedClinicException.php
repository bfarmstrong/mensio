<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

/**
 * Exception that is thrown when a clinic is required to perform an action.
 */
class NoSelectedClinicException extends Exception
{
    /**
     * Renders the error.
     *
     * @return Response
     */
    public function render()
    {
        return view('errors.no-selected-clinic');
    }
}
