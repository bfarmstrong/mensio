<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the answer service.
 */
class AnswerService extends BaseService implements IAnswerService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Answer::class;
    }

    /**
     * Creates a new answer or updates an existing answer.
     *
     * @param mixed $response
     * @param mixed $question
     * @param mixed $item
     * @param mixed $value
     *
     * @return Model
     */
    public function updateOrCreate($response, $question, $item, $value)
    {
        return $this->model->updateOrCreate([
            'question_id' => $question,
            'response_id' => $response,
        ], [
            'question_item_id' => $item,
            'value' => is_null($item) ? json_encode($value) : null,
        ]);
    }
}
