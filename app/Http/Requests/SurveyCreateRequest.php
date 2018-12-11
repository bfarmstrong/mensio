<?php

namespace App\Http\Requests;

use App\Models\Group;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class SurveyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'questionnaire_id' => 'required',
                'description' => 'required',
                'name' => 'required',
            ];
        
    }
}
