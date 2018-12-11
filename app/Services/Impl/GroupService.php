<?php

namespace App\Services\Impl;

use App\Enums\Roles;
use App\Services\BaseService;
use Illuminate\Support\Collection;

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

    /**
     * Returns all groups that the user is a member of.
     *
     * @param mixed $user
     *
     * @return Collection
     */
    public function findByClient($user)
    {
        $userService = app(UserService::class);
        $user = $userService->find($user);

        return $this->model->whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();
    }

    /**
     * Returns the list of clients in a group.
     *
     * @param mixed $group
     *
     * @return Collection
     */
    public function findClients($group)
    {
        $group = $this->find($group);

        return $group->users()->whereHas('role', function ($query) {
            $query->where('level', Roles::Client);
        })->get();
    }

    /**
     * Returns the list of therapists in a group.
     *
     * @param mixed $group
     *
     * @return Collection
     */
    public function findTherapists($group)
    {
        $group = $this->find($group);

        return $group->users()->whereHas('role', function ($query) {
            $query->where('level', Roles::JuniorTherapist)
                ->orWhere('level', Roles::SeniorTherapist);
        })->get();
    }
}
