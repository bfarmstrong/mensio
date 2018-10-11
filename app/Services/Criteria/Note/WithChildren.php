<?php

namespace App\Services\Criteria\Note;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which joins to the children relationship.
 */
class WithChildren extends Criteria
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
        $query = $model->with('children');

        return $query;
    }
}
