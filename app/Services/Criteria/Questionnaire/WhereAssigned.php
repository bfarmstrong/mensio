<?php

namespace App\Services\Criteria\Questionnaire;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that the response is assigned to the user that is
 * passed.
 *
 * @example
 *
 * Retrieve all incomplete responses connected to the current user
 *
 * protected IResponseService $service;
 * $service
 *     ->getByCriteria(new WhereAssigned(Auth::id()))
 *     ->findBy('complete', false);
 */
class WhereAssigned extends Criteria
{
    /**
     * The identifier of the user to check for whether or not they are assigned
     * the response.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereAssigned`.
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
        $query = $model->where('user_id', $this->id);

        return $query;
    }
}
