<?php

namespace App\Services;

/**
 * Base contract for a service class.
 */
interface IBaseService
{
    public function all();

    public function create(array $attributes);

    public function delete($id);

    public function find($id);

    public function findBy($field, $value);

    public function paginate(int $limit = 15);

    public function update($id, array $attributes);
}
