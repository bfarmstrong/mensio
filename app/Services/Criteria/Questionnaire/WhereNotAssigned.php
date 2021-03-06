<?php

namespace App\Services\Criteria\Questionnaire;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that the response is not assigned to the user that is
 * passed.
 */
class WhereNotAssigned extends Criteria
{
    /**
     * The identifier of the user to check for whether or not they are assigned
     * the response.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereNotAssigned`.
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
        $query = $model->whereDoesntHave('responses', function ($query) {
            $query->where('user_id', $this->id);
        });

        return $query;
    }
}
