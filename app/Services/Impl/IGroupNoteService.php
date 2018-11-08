<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the group service.
 */
interface IGroupNoteService extends IBaseService
{
    public function addAddition($note, string $addition);
}
