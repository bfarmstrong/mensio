<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the questionnaire service.
 */
class QuestionnaireService extends BaseService implements IQuestionnaireService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Questionnaire::class;
    }
}
