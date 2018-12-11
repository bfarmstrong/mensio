<?php

namespace App\Services;

/**
 * Base contract for a service class.
 */
interface IBaseService
{
    public function optional(bool $optional = true);

    public function all();

    public function create(array $attributes);

    public function delete($id);

    public function find($id);

    public function findBy($field, $value = null);

    public function paginate(int $limit = 15, string $page = 'page');

    public function search(string $query);

    public function update($id, array $attributes);
}
