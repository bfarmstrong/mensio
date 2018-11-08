<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Validation rule that checks if the value is a base64 encoded image.
 */
class Base64 implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_null($value)) {
            $image = base64_decode($value);
            $file = finfo_open();
            $result = finfo_buffer($file, $image, FILEINFO_MIME_TYPE);

            return $result == 'image/png';
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a base64 encoded image.';
    }
}
