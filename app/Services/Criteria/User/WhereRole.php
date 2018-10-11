<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which filters users by a specific role level.
 */
class WhereRole extends Criteria
{
    /**
     * The level that will be queried for.
     *
     * @var int
     */
    protected $level;

    /**
     * Creates an instance of `WhereRole`.
     *
     * @param int $level
     */
    public function __construct(int $level)
    {
        $this->level = $level;
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
        $query = $model->whereHas('role', function ($query) {
            $query->where('level', $this->level);
        });

        return $query;
    }
}
