<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the response service.
 */
class ResponseService extends BaseService implements IResponseService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Response::class;
    }
}
