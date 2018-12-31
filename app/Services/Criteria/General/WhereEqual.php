<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that a column equals a specific value.
 */
class WhereEqual extends Criteria
{
    /**
     * The column to search through.
     *
     * @var string
     */
    protected $column;

    /**
     * The value to compare the column against.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Creates an instance of `WhereEqual`.
     *
     * @param string $column
     * @param mixed  $value
     */
    public function __construct(string $column, $value)
    {
        $this->column = $column;
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
        $query = $model->where($this->column, $this->value);

        return $query;
    }
}
