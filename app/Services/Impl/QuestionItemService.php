<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the question item service.
 */
class QuestionItemService extends BaseService implements IQuestionItemService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\QuestionItem::class;
    }
}
