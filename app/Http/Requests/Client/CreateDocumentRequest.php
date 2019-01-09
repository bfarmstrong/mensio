<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request object for a therapist to create a note for a client.
 */
class CreateDocumentRequest extends FormRequest
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
            'name' => 'required',
            'file' => 'required',
            'signature.license' => 'required_if:is_signed,1',
            'signature.name' => 'required_if:is_signed,1',
        ];
    }
}
