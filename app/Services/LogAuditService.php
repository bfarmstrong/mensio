<?php

namespace App\Services;

use App\Models\LogAudit;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Service to manage the log audits.
 */
class LogAuditService
{
    /**
     * The model object that the service will use to access the activity data.
     *
     * @var Model
     */
    protected $model;

    /**
     * Creates an instance of `LogAuditService`.
     *
     * @param LogAudit $model
     */
    public function __construct(LogAudit $model) {
        $this->model = $model;
    }

    /**
     * Returns the list of all logs.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Searches for a specific log in the database.  Returns the log object.
     *
     * @param string $id
     *
     * @return LogAudit
     */
    public function find(string $id)
    {
        $log = $this->model->find($id);
        activity()->performedOn($log)->log('viewed');
        return $log;
    }

    /**
     * Returns a paginated list of logs.
     *
     * @return LengthAwarePaginator
     */
    public function paginate()
    {
        return $this->model->orderBy('created_at', 'desc')->paginate();
    }
}
