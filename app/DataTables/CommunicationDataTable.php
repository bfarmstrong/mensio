<?php

namespace App\DataTables;

use App\Models\CommunicationLog;
use Yajra\DataTables\Services\DataTable;

class CommunicationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', 'communication.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\CommunicationLog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CommunicationLog $model)
    {
        return $model->newQuery()->select('id','actions', 'appointment_date','notes' , 'digital_signature');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'Appointment Date',
			'Actions',
            'Notes',
            'Digital Signature'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'communication_' . date('YmdHis');
    }
}
