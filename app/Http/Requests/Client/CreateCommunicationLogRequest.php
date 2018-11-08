<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the request to create a new communication log.
 */
class CreateCommunicationLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'appointment_date' => 'required|date',
            'notes' => 'sometimes|string',
            'reason' => 'required',
        ];
    }
}
