<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogAuditService;
use Illuminate\Http\Response;

class LogAuditController extends Controller
{
    /**
     * The service to access the log audits.
     *
     * @var LogAuditService
     */
    protected $service;

    /**
     * Creates an instance of `LogAuditController`.
     *
     * @param LogAuditService $logAuditService
     */
    public function __construct(LogAuditService $logAuditService)
    {
        $this->service = $logAuditService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $logs = $this->service->paginate();

        return view('admin.logs.index')->with('logs', $logs);
    }

    /**
     * Displays a specific log.
     *
     * @param string $id
     *
     * @return Response
     */
    public function show(string $id)
    {
        $log = $this->service->find($id);

        if (is_null($log)) {
            abort(404);
        }

        return view('admin.logs.show')->with('log', $log);
    }
}
