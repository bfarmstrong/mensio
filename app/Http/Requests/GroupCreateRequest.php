<?php

namespace App\Http\Requests;

use App\Models\Group;
use Auth;
use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
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
        if (isset($this->input()['user_id'])) {
            return [
                'group_id' => 'required',
                'user_id' => 'required',
            ];
        } else {
            return Group::$rules;
        }
    }
}
