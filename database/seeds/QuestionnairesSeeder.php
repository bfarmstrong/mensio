<?php

use App\Models\Survey;
use App\Services\Impl\QuestionnaireService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Seeds the existing questionnaires in the storage folder.
 */
class QuestionnairesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questionnaireService = app(QuestionnaireService::class);

        $survey = factory(Survey::class)->create([
            'name' => 'Default',
        ]);

        $jsonFiles = Storage::files('questionnaires');
        foreach ($jsonFiles as $jsonFile) {
            // In this special case we want the file name to be the name of
            // the questionnaire in the database.
            $fileName = pathinfo($jsonFile, PATHINFO_FILENAME);
            $data = json_decode(Storage::get($jsonFile));
            $questionnaire = $questionnaireService->importFromJson($data);
            $questionnaireService->update($questionnaire->id, [
                'name' => $fileName,
                'scoring_method' => 'sum',
            ]);
            $survey->questionnaires()->save($questionnaire);
        }
    }
}
