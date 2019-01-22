<?php

namespace App\DataTables;

use App\Models\CommunicationLog;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTablesEditor;
use Illuminate\Database\Eloquent\Model;

class CommunicationDataTablesEditor extends DataTablesEditor
{
    protected $model = CommunicationLog::class;

    /**
     * Get create action validation rules.
     *
     * @return array
     */
    public function createRules()
    {
        return [
            'appointment_date' => 'sometimes',
            'notes'  => 'sometimes',
        ];
    }

    /**
     * Get edit action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function editRules(Model $model)
    {
        return [
            'appointment_date' => 'sometimes',
            'notes'  => 'sometimes',
        ];
    }

    /**
     * Get remove action validation rules.
     *
     * @param Model $model
     * @return array
     */
    public function removeRules(Model $model)
    {
        return [];
    }
}
