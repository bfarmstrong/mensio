<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates the request to manage questionnaires for a group.
 */
class ManageQuestionnairesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_submit' => 'required|boolean',
            'questionnaire_id' => 'required|exists:questionnaires,id',
        ];
    }
}
