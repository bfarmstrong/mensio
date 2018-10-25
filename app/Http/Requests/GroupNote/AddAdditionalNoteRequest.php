<?php

namespace App\Http\Requests\GroupNote;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request object for a therapist to add additional information to a note.
 */
class AddAdditionalNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'addition' => 'required',
        ];
    }
}
