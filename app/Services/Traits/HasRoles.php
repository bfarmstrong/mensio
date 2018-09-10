<?php

namespace App\Services\Traits;

trait HasRoles
{
    /**
     * Assign a role to the user
     *
     * @param  string $roleName
     * @param  integer $userId
     * @return void
     */
    public function assignRole($roleName, $userId)
    {
        $role = $this->role->findByName($roleName);
        $user = $this->model->find($userId);
        $user->role_id = $role->id;
        $user->save();
    }

}
