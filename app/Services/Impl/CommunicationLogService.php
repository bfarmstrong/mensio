<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Implementation of the communication log service.
 */
class CommunicationLogService extends BaseService implements ICommunicationLogService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\CommunicationLog::class;
    }
}
