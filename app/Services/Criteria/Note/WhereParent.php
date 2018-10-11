<?php

namespace App\Services\Criteria\Note;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that the note is a parent note.
 */
class WhereParent extends Criteria
{
    /**
     * Applies the criteria.
     *
     * @param Model        $model
     * @param IBaseService $service
     *
     * @return Model
     */
    public function apply($model, IBaseService $service)
    {
        $query = $model->whereNull('note_id');

        return $query;
    }
}
