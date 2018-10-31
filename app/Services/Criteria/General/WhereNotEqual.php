<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that a column does not equal a specific value.
 */
class WhereNotEqual extends Criteria
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
     * Creates an instance of `WhereNotEqual`.
     *
     * @param string $column
     * @param string $value
     */
    public function __construct(string $column, string $value)
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
        $query = $model->where($this->column, '!=', $this->value);

        return $query;
    }
}
