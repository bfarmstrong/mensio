<?php

namespace App\Http\Requests\GroupNote;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request object for a therapist to create a note for a client.
 */
class CreateGroupNoteRequest extends FormRequest
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
            'contents' => 'required',
            'is_draft' => 'required|boolean',
            'group_id' => 'required|exists:groups,id',
            'signature.license' => 'required_if:is_draft,0',
            'signature.name' => 'required_if:is_draft,0',
        ];
    }
}
