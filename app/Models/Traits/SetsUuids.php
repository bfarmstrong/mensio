<?php

namespace App\Models\Traits;

use Webpatser\Uuid\Uuid;

/**
 * SetsUuids.
 *
 * Sets UUIDs for an entity whenever it is created.  Allows multiple UUIDs to
 * be defined.  Would be used as below:
 *
 * @example
 *
 * class Response extends Model
 * {
 *     use SetsUuids;
 *     protected $uuids = ['uuid'];
 * }
 */
trait SetsUuids
{
    /**
     * Sets the UUIDs to be saved whenever an entity is saved to the database.
     *
     * @return void
     */
    protected static function bootSetsUuids()
    {
        static::creating(function ($instance) {
            foreach ($instance->getUuidColumns() as $uuidColumn) {
                $instance[$uuidColumn] = Uuid::generate()->string;
            }
        });
    }

    /**
     * Returns the UUID columns.
     *
     * @return array
     */
    protected function getUuidColumns()
    {
        return $this->uuids ?? [];
    }
}
