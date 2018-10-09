<?php

namespace App\Services\Criteria\Questionnaire;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria that checks if the response is attached to the entity.
 */
class WhereResponse extends Criteria
{
    /**
     * The identifier of the response to compare against.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereResponse`.
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
        $query = $model->where('response_id', $this->id);

        return $query;
    }
}
