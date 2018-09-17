<?php

namespace App\Models;

use App\Models\Traits\Encryptable;
use App\Models\Traits\Uuids;
use Spatie\Activitylog\Models\Activity;


/**
 * An audit for a distinct action in the system.  It consists of a causer
 * performing an action against a subject with extra optional metadata attached.
 */
class LogAudit extends Activity
{
    use Encryptable;
    use Uuids;

    /**
     * Indicates that the table uses a string for its key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates that the table does not have an auto incrementing key.
     *
     * @var boolean
     */
    public  $incrementing = false;

    /**
     * The columns in the activity log that are encrypted.
     *
     * @var array
     */
    protected $encrypts = ['properties'];
}
