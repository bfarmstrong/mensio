<?php

namespace App\Services\Impl;

use App\Services\BaseService;

/**
 * Implementation of the role service.
 */
class RoleService extends BaseService implements IRoleService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Role::class;
    }
}
