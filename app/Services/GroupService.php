<?php

namespace App\Services;

use App\Models\Group;
use DB;
use Exception;
use Illuminate\Support\Facades\Schema;

class GroupService
{
    public function __construct(
        Group $model,
        UserService $userService
    ) {
        $this->model = $model;
        $this->userService = $userService;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters
    |--------------------------------------------------------------------------
    */

    /**
     * All groups.
     *
     * @return \Illuminate\Support\Collection|null|static|Group
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Paginated groups.
     *
     * @return \Illuminate\Support\Collection|null|static|Group
     */
    public function paginated()
    {
        return $this->model->paginate(env('PAGINATE', 25));
    }

    /**
     * Find a group.
     *
     * @param int $id
     *
     * @return \Illuminate\Support\Collection|null|static|Group
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Search the groups.
     *
     * @param string $input
     *
     * @return \Illuminate\Support\Collection|null|static|Group
     */
    public function search($input)
    {
        $query = $this->model->orderBy('name', 'desc');

        $columns = Schema::getColumnListing('groups');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input.'%');
        }

        return $query->paginate(env('PAGINATE', 25));
    }

    /**
     * Find Group by name.
     *
     * @param string $name
     *
     * @return \Illuminate\Support\Collection|null|static|Group
     */
    public function findByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    /*
    |--------------------------------------------------------------------------
    | Setters
    |--------------------------------------------------------------------------
    */

    /**
     * Create a group.
     *
     * @param array $input
     *
     * @return Group
     */
    public function create($input)
    {
        try {
            return $this->model->create($input);
        } catch (Exception $e) {
            throw new Exception('Failed to create group', 1);
        }
    }

    /**
     * Update a group.
     *
     * @param int   $id
     * @param array $input
     *
     * @return bool
     */
    public function update($id, $input)
    {
        $group = $this->model->find($id);
        $group->update($input);

        return $group;
    }

    /**
     * Destroy the group.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $result = false;
                $userCount = count($this->userService->findByGroupID($id));

                if (0 == $userCount) {
                    $result = $this->model->find($id)->delete();
                }

                return $result;
            });
        } catch (Exception $e) {
            throw new Exception('We were unable to delete this group', 1);
        }

        return $result;
    }
}
