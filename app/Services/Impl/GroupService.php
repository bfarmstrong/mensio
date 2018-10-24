<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the Group service.
 */
class GroupService extends BaseService implements IGroupService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Group::class;
    }
}
