<?php

namespace App\Services\Criteria\Note;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which filters notes by a specific client.
 */
class WhereClient extends Criteria
{
    /**
     * The client that will be queried for.
     *
     * @var string
     */
    protected $client;

    /**
     * Creates an instance of `WhereClient`.
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
        $query = $model->where('client_id', $this->client);

        return $query;
    }
}
