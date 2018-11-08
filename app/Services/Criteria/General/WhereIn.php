<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that a column equals a specific value.
 */
class WhereIn extends Criteria
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
     * @var string
     */
    protected $value;

    /**
     * Creates an instance of `WhereIn`.
     *
     * @param string $column
     * @param string $value
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
        $query = $model->whereIn($this->column, $this->value);

        return $query;
    }
}
