<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that a column does not equal a specific value in a
 * different relation.
 */
class WhereRelationNotEqual extends Criteria
{
    /**
     * The column to search through.
     *
     * @var string
     */
    protected $column;

    /**
     * The relation to search against.
     *
     * @var string
     */
    protected $relation;

    /**
     * The value to compare the column against.
     *
     * @var string
     */
    protected $value;

    /**
     * Creates an instance of `WhereRelationNotEqual`.
     *
     * @param string $relation
     * @param string $column
     * @param string $value
     */
    public function __construct(string $relation, string $column, string $value)
    {
        $this->column = $column;
        $this->relation = $relation;
        $this->value = $value;
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
        $query = $model->whereHas($this->relation, function ($query) {
            $query->where($this->column, '!=', $this->value);
        });

        return $query;
    }
}
