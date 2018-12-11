<?php

namespace App\Console\Commands;

use App\Services\Impl\IQuestionnaireService;
use Illuminate\Console\Command;
use Validator;

/**
 * Imports a questionnaire from either a string or JSON file.
 */
class ImportQuestionnaire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:questionnaire {--name=} {--scoring-method=} {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a questionnaire from a string or file';

    /**
     * The service class to import questionnaires with.
     *
     * @var IQuestionnaireService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(IQuestionnaireService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $validator = Validator::make($this->arguments(), [
            'data' => ['json', 'required'],
        ]);

        if ($validator->fails()) {
            $this->info('Unable to import questionnaire.  See errors.');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        // Pass the object representation of the data to the service
        $decoded = json_decode($this->argument('data'));
        $this->service->importFromJson(
            $decoded,
            [
                'name' => $this->option('name'),
                'scoring_method' => $this->option('scoring-method'),
            ]
        );
        $this->info('Questionnaire was imported successfully.');
    }
}
