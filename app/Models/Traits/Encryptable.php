<?php

namespace App\Models\Traits;

trait Encryptable
{
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();
        foreach ($this->getEncrypts() as $key) {
            if (
                array_key_exists($key, $attributes) &&
                ! is_null($attributes[$key])
            ) {
                $attributes[$key] = decrypt($attributes[$key]);
            }
        }

        return $attributes;
    }

    public function getAttributeValue($key)
    {
        if (
            in_array($key, $this->getEncrypts()) &&
            ! is_null($this->attributes[$key])
        ) {
            return decrypt($this->attributes[$key]);
        }

        return parent::getAttributeValue($key);
    }

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->getEncrypts()) && ! is_null($value)) {
            $this->attributes[$key] = encrypt($value);
        } else {
            parent::setAttribute($key, $value);
        }

        return $this;
    }

    protected function getEncrypts()
    {
        return property_exists($this, 'encrypts') ? $this->encrypts : [];
    }
}
