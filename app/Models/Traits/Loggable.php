<?php

namespace App\Models\Traits;

use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Adds the defaults for activity logging to a model.
 */
trait Loggable
{
    use LogsActivity;

    /**
     * Log all attributes by default.
     *
     * @var array
     */
    protected static $logAttributes = ['*'];

    /**
     * Ignore the timestamps by default.
     *
     * @var array
     */
    protected static $logAttributesToIgnore = ['created_at', 'updated_at'];

    /**
     * Only log the attributes that have changed.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;
}
