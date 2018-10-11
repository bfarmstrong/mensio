<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which joins to a specified relationship.
 */
class WithRelation extends Criteria
{
    /**
     * The relationship to load.
     *
     * @var string
     */
    protected $relationship;

    /**
     * Creates an instance of `WithRelation`.
     *
     * @param string $relationship
     */
    public function __construct(string $relationship)
    {
        $this->relationship = $relationship;
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
        $query = $model->with($this->relationship);

        return $query;
    }
}
