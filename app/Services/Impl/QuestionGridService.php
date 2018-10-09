<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the question grid service.
 */
class QuestionGridService extends BaseService implements IQuestionGridService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\QuestionGrid::class;
    }
}
