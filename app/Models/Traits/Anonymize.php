<?php

namespace App\Models\Traits;

use Faker\Factory;

/**
 * Given a list of anonymous columns.  Anonymizes the columns with fake data.
 */
trait Anonymize
{
    /**
     * Whenever the instance is created, anonymize the anonymized columns.
     *
     * @return void
     */
    protected static function bootAnonymize()
    {
        $faker = Factory::create();

        static::creating(function ($instance) use ($faker) {
            if (config('anonymize.enabled') === true) {
                foreach ($instance->getAnonymizedColumns() as $column => $fn) {
                    if (! is_null($instance[$column])) {
                        $instance[$column] = $faker->$fn;
                    }
                }
            }
        });
    }

    /**
     * Returns the columns that should be anonymized.
     *
     * @return void
     */
    protected function getAnonymizedColumns()
    {
        return $this->anonymize;
    }
}
