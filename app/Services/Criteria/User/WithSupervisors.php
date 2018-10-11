<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which joins to the supervisors relationship if applicable.
 */
class WithSupervisors extends Criteria
{
    /**
     * The client that completes the relationship.
     *
     * @var string
     */
    protected $client;

    /**
     * Creates an instance of `WithSupervisors`.
     *
     * @param string $client
     */
    public function __construct(string $client)
    {
        $this->client = $client;
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
        $query = $model->with(['supervisors' => function ($query) {
            $query->where('client_id', $this->client);
        }]);

        return $query;
    }
}
