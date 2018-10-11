<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which orders a column either ascending or descending.
 */
class OrderBy extends Criteria
{
    /**
     * The column to order by.
     *
     * @var string
     */
    protected $column;

    /**
     * The direction to order that column by.
     *
     * @var string
     */
    protected $direction;

    /**
     * Creates an instance of `OrderBy`.
     *
     * @param string $column
     * @param string $direction
     */
    public function __construct(string $column, string $direction = 'asc')
    {
        $this->column = $column;
        $this->direction = $direction;
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
        $query = $model->orderBy($this->column, $this->direction);

        return $query;
    }
}
