<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the survey service.
 */
class SurveyService extends BaseService implements ISurveyService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Survey::class;
    }
}
