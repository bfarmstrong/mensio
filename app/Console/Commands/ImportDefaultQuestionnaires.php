<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Alias command for seeding questionnaires.
 */
class ImportDefaultQuestionnaires extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:default-questionnaires';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports questionnaires from the storage folder';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => 'QuestionnairesSeeder',
        ]);
    }
}
