<?php

namespace App\Console\Commands;

use App\Enums\Languages;
use App\Enums\Sheets;
use App\Importer\IImporter;
use Illuminate\Console\Command;

/**
 * Command to execute an import of the Google Sheets legacy data.
 */
class ImportSheetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sheet-data {sheet} {--language=en}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports legacy data from a Google Sheet';

    /**
     * The importer implementation.
     *
     * @var IImporter
     */
    protected $importer;

    /**
     * Create a new command instance.
     *
     * @param IImporter $importer
     *
     * @return void
     */
    public function __construct(IImporter $importer)
    {
        parent::__construct();

        $this->importer = $importer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Validates the language option
        $language = $this->option('language');
        if (! Languages::hasValue($language)) {
            $this->error('Selected language is not available.');

            return;
        }

        // Executes the importer
        $this->info('Beginning the import process.');
        switch ($this->argument('sheet')) {
            case 'assess':
                $this->importer->importAssess($language);
                break;
            case 'mbct':
                $this->importer->importMbct($language);
                break;
            case 'mbsr':
                $this->importer->importMbsr($language);
                break;
            default:
                $this->error('Selected sheet is not available.');
        }
        $this->info('Import process was successful.');
    }
}
