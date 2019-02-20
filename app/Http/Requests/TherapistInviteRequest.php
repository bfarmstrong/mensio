<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TherapistInviteRequest extends FormRequest
{
    /**
     * Determine if the therapist is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->can('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|unique:users',
        ];
    }
}
