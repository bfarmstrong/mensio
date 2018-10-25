<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the doctor service.
 */
class DoctorService extends BaseService implements IDoctorService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Doctor::class;
    }
}
