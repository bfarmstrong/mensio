<?php

namespace App\Services\Criteria\Questionnaire;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria to add questions and question items to a questionnaire when loading
 * it.
 */
class WithQuestionsAndItems extends Criteria
{
    /**
     * Applies the criteria.
     *
     * @param Model        $model
     * @param IBaseService $service
     *
     * @return Model
     */
    public function apply($model, IBaseService $service)
    {
        $query = $model->with('questions.questionItems');

        return $query;
    }
}
