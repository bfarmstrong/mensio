<?php

namespace App\Services\Criteria\General;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which searches for a field and does not take case into account.
 */
class WhereCaseInsensitive extends Criteria
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
     * Creates an instance of `WhereCaseInsensitive`.
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
        $query = $model->whereRaw(
            "LOWER(`$this->column`) LIKE ?",
            strtolower($this->value)
        );

        return $query;
    }
}
