<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * The service provider to provide importer services to the container.
 */
class ImporterServiceProvider extends ServiceProvider
{
    /**
     * The services that are exposed to the container.
     *
     * @var array
     */
    public $bindings = [
        \App\Importer\IImporter::class => \App\Importer\Importer::class,
        \App\Importer\ILegacyApiService::class => \App\Importer\LegacyApiService::class,
        \App\Importer\ISheetsService::class => \App\Importer\SheetsService::class,
    ];
}
