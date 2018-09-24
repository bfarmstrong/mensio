<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which that the given therapist is not a therapist of the user.
 */
class WhereNotCurrentTherapist extends Criteria
{
    /**
     * The identifier of the user to ensure the therapist is not currently
     * tied to the user.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereNotCurrentTherapist`.
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
        $query = $model->whereDoesntHave('patients', function ($query) {
            $query->where('patient_id', $this->id);
        });

        return $query;
    }
}
