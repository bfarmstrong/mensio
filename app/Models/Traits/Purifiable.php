<?php

namespace App\Models\Traits;

use Stevebauman\Purify\Facades\Purify;

/**
 * Automatically cleanses markup of any XSS vulnerabilities.
 */
trait Purifiable
{
    /**
     * Purifies any malicious markup from an attribute when it is set.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->purifiable) && is_string($value)) {
            $this->attributes[$key] = Purify::clean($value);
        }
        $this->attributes[$key] = $value;
    }
}
