<?php

namespace App\Http\Requests;

use App\Rules\Base64;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSignatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'signature_base64' => [
                'sometimes',
                'required_without:signature_file',
                new Base64(),
            ],
            'signature_file' => 'sometimes|required_without:signature_base64|file|mimetypes:image/*',
        ];
    }
}
