<?php

namespace App\Importer;

/**
 * Contract that a Google Sheet service satisfies.
 */
interface ISheetsService
{
    public function getSheetAsCsv(string $id);
}
