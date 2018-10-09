<?php

namespace App\Services\Impl;

use App\Services\IBaseService;

/**
 * Interface for the response service.
 */
interface IResponseService extends IBaseService
{
    public function answer($response, string $answers);

    public function assignToClient($client, $questionnaire);

    public function getScore($response);

    public function unassignFromClient($client, $questionnaire);
}
