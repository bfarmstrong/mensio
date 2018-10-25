<?php

namespace App\Importer;

/**
 * Contract that the legacy API service satisfies.
 */
interface ILegacyApiService
{
    public function getUserData();
}
