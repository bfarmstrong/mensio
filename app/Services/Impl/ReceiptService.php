<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * Implementation of the receipt service.
 */
class ReceiptService extends BaseService implements IReceiptService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Receipt::class;
    }
}
