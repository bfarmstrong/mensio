<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the answer service.
 */
interface IAnswerService extends IBaseService
{
    public function updateOrCreate($response, $question, $item, $value);
}
