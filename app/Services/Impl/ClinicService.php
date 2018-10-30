<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the Clinic service.
 */
class ClinicService extends BaseService implements IClinicService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Clinic::class;
    }
}
