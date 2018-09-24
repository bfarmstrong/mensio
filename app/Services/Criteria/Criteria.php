<?php

namespace App\Services\Criteria;

use App\Services\IBaseService;

/**
 * Class for a criteria.  A criteria is an object which will modify a query
 * performed by a service.
 */
abstract class Criteria
{
    abstract public function apply($model, IBaseService $service);
}
