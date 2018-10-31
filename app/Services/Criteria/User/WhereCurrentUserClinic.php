<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which checks that the given clinics is a therapist of the user.
 */
class WhereCurrentUserClinic extends Criteria
{
    /**
     * The identifier of the user to ensure the clinics is currently tied to the
     * user.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereCurrentClient`.
     *
     * @param mixed $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

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
        $query = $model->whereHas('clinics', function ($query) {
            $query->where('clinic_id', $this->id);
        });

        return $query;
    }
}
