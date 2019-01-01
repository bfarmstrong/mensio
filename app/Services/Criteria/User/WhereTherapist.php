<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that the user is a therapist.
 */
class WhereTherapist extends Criteria
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
        $query = $model->whereHas('roles', function ($query) {
            $query->where(function ($query) {
                $query->where('level', 2)
                    ->orWhere('level', 3);
            });
        });

        return $query;
    }
}
