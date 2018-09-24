<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which joins to the patients relationship if applicable.
 */
class WithPatients extends Criteria
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
        $query = $model->with('patients');

        return $query;
    }
}
