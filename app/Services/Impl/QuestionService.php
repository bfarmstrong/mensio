<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the question service.
 */
class QuestionService extends BaseService implements IQuestionService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Question::class;
    }
}
