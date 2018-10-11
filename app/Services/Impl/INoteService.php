<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the note service.
 */
interface INoteService extends IBaseService
{
    public function addAddition($note, string $addition);
}
