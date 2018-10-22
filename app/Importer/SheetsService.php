<?php

namespace App\Importer;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * The implementation of the Google Sheet service.  Allows interaction with
 * Google Sheet data.
 */
class SheetsService implements ISheetsService
{
    /**
     * The client to communicate with the Google Sheets API.
     *
     * @var Client
     */
    protected $client;

    /**
     * Creates an instance of `SheetsService`.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://docs.google.com',
        ]);
    }

    /**
     * Returns the URL for the public sheet.
     *
     * @param string $id
     *
     * @return string
     */
    protected function buildUrl(string $id)
    {
        return "spreadsheets/d/$id/pub";
    }

    /**
     * Exports a string to a CSV equivalent.
     *
     * @param string $data
     *
     * @return Collection
     */
    protected function exportAsCsv(string $data)
    {
        $rows = collect(explode("\r\n", $data));

        return $rows->map(function ($row) {
            return collect(str_getcsv(trim($row)));
        });
    }

    /**
     * Retrieves a sheet from Google Sheets.  Returns the CSV representation of
     * it.
     *
     * @param string $id
     *
     * @return Collection
     */
    public function getSheetAsCsv(string $id)
    {
        $data = $this->client
            ->get($this->buildUrl($id), [
                'query' => [
                    'output' => 'csv',
                ],
            ])
            ->getBody()
            ->getContents();

        return $this->exportAsCsv($data);
    }
}
