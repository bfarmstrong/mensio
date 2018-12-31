<?php

namespace App\Console\Commands;

use App\Importer\IImporter;
use Illuminate\Console\Command;

/**
 * Command to execute an import of the users from the legacy software.
 */
class ImportLegacyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:legacy-users {--clinic=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports users from the legacy API';

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
        $this->info('Beginning the import process.');
        $this->importer->importLegacyUserData($this->option('clinic'));
        $this->info('Import process was successful.');
    }
}
