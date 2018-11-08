<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the receipt service.
 */
interface IReceiptService extends IBaseService
{
    public function exportAsPdf($receipt);
}
