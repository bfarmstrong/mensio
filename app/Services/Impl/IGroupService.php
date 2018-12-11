<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the group service.
 */
interface IGroupService extends IBaseService
{
    public function findByClient($user);

    public function findClients($group);

    public function findTherapists($group);
}
