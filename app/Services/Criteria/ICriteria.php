<?php

namespace App\Services\Criteria;

/**
 * Functionality that a service must be able to provide in order to support
 * criteria.
 */
interface ICriteria
{
    public function skipCriteria(bool $status = true);

    public function getCriteria();

    public function getByCriteria(Criteria $criteria);

    public function pushCriteria(Criteria $criteria);

    public function resetCriteria();

    public function applyCriteria();
}
