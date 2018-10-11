<?php

namespace App\Services\Criteria\Note;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which joins to the therapist relationship.
 */
class WithTherapist extends Criteria
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
        $query = $model->with('therapist');

        return $query;
    }
}
