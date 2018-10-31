<?php

namespace App\Services\Criteria\User;

use App\Services\Criteria\Criteria;
use App\Services\IBaseService;
use Auth;
use Illuminate\Database\Eloquent\Model;

/**
 * Criteria which ensures that the clinics is not assigned to the user that is
 * passed.
 */
class WhereNotAssignedClinic extends Criteria
{
    /**
     * The identifier of the user to check for whether or not they are assigned
     * the clinics.
     *
     * @var mixed
     */
    protected $id;

    /**
     * Creates an instance of `WhereNotAssigned`.
     *
     * @param mixed $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

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
        if (!Auth::user()->isSuperAdmin()) {
            $query = $model
                ->whereHas('role', function ($query) {
                    $query->where('level', '<=', 3);
				})
				->whereDoesntHave('clinics', function ($query) {
					$query->where('clinic_id', $this->id);
				});
		} else {
            $query = $model
                ->whereHas('role', function ($query) {
					$query->where('level', 4);
				})
				->whereDoesntHave('clinics', function ($query) {
					$query->where('clinic_id', $this->id);
				});
        }

        return $query;
    }
}
