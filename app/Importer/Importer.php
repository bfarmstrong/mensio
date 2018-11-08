<?php

namespace App\Importer;

use App\Enums\Roles;
use App\Enums\Sheets;
use App\Enums\SheetsMapping;
use App\Models\User;
use App\Services\Criteria\General\WhereCaseInsensitive;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IAnswerService;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IQuestionGridService;
use App\Services\Impl\IQuestionItemService;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IQuestionService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IRoleService;
use App\Services\Impl\IUserService;
use DB;
use Hash;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Validator;

/**
 * Implementation of the importer for the legacy Google Sheet data.
 */
class Importer implements IImporter
{
    /**
     * The answer service implementation.
     *
     * @var IAnswerService
     */
    protected $answerService;

    /**
     * The clinic service implementation.
     *
     * @var IClinicService
     */
    protected $clinicService;

    /**
     * The legacy API service implementation.
     *
     * @var ILegacyApiService
     */
    protected $legacyApiService;

    /**
     * The questionnaire service implementation.
     *
     * @var IQuestionnaireService
     */
    protected $questionnaireService;

    /**
     * The question service implementation.
     *
     * @var IQuestionService
     */
    protected $questionService;

    /**
     * The question grid service implementation.
     *
     * @var IQuestionGridService
     */
    protected $questionGridService;

    /**
     * The question item service implementation.
     *
     * @var IQuestionItemService
     */
    protected $questionItemService;

    /**
     * The response service implementation.
     *
     * @var IResponseService
     */
    protected $responseService;

    /**
     * The role service implementation.
     *
     * @var IRoleService
     */
    protected $roleService;

    /**
     * The sheet service implementation.
     *
     * @var ISheetService
     */
    protected $sheetsService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `Importer`.
     *
     * @param IAnswerService        $answerService
     * @param IClinicService        $clinicService
     * @param ILegacyApiService     $legacyApiService
     * @param IQuestionnaireService $questionnaireService
     * @param IQuestionService      $questionService
     * @param IQuestionGridService  $questionGridService
     * @param IQuestionItemService  $questionItemService
     * @param IResponseService      $responseService
     * @param IRoleService          $roleService
     * @param ISheetsService        $sheetsService
     * @param IUserService          $userService
     */
    public function __construct(
        IAnswerService $answerService,
        IClinicService $clinicService,
        ILegacyApiService $legacyApiService,
        IQuestionnaireService $questionnaireService,
        IQuestionService $questionService,
        IQuestionGridService $questionGridService,
        IQuestionItemService $questionItemService,
        IResponseService $responseService,
        IRoleService $roleService,
        ISheetsService $sheetsService,
        IUserService $userService
    ) {
        $this->answerService = $answerService;
        $this->clinicService = $clinicService;
        $this->legacyApiService = $legacyApiService;
        $this->questionnaireService = $questionnaireService;
        $this->questionService = $questionService;
        $this->questionGridService = $questionGridService;
        $this->questionItemService = $questionItemService;
        $this->responseService = $responseService;
        $this->roleService = $roleService;
        $this->sheetsService = $sheetsService;
        $this->userService = $userService;
    }

    /**
     * Removes odd formatting from the legacy data to more closely match the
     * current data.
     *
     * @param string $field
     *
     * @return string
     */
    protected function getCleanedField(string $field)
    {
        return preg_replace('/\d+[.\-\ ]*\ /', '', $field);
    }

    /**
     * Returns the raw CSV data.
     *
     * @param string $sheet
     *
     * @return Collection
     */
    protected function getRawCsvData(string $sheet)
    {
        return $this->sheetsService->getSheetAsCsv($sheet);
    }

    /**
     * Returns an array of data for a client, sanitized.
     *
     * @param Collection $row
     * @param array      $mapping
     *
     * @return array
     */
    protected function getClientData(Collection $row, array $mapping)
    {
        return [
            'email' => $row->get($mapping['general_info.email']),
            'name' => $row->get($mapping['general_info.first_name'])
                .' '.$row->get($mapping['general_info.last_name']),
            'phone' => $row->get($mapping['general_info.phone']),
        ];
    }

    /**
     * Returns a special mapping for a question, if applicable.
     *
     * @param string $question
     *
     * @return string
     */
    protected function getSpecialMapping(string $question)
    {
        switch ($question) {
            case 'general_info.first_name':
                return 'general_info.full_name.first_name';
            case 'general_info.last_name':
                return 'general_info.full_name.last_name';
        }

        return $question;
    }

    /**
     * Processes an answer to a questionnaire.
     *
     * @param User   $client
     * @param string $question
     * @param string $answer
     * @param string $header
     *
     * @return void
     */
    protected function processAnswer(
        User $client,
        string $question,
        string $answer,
        string $header
    ) {
        // If the answer is empty, don't save it to the database
        if (empty(trim($answer))) {
            return;
        }

        // Fetch the main questionnaire from the database
        $questionnaire = $this->questionnaireService->findBy(
            'name',
            'all_basic_qs'
        );
        if (is_null($questionnaire)) {
            return;
        }

        // Find an existing response or create one if necessary
        $responseArray = [
            'questionnaire_id' => $questionnaire->id,
            'user_id' => $client->id,
        ];
        $response = $this->responseService
            ->optional()
            ->findBy($responseArray);
        if (is_null($response)) {
            $response = $this->responseService->create(
                array_merge(
                    $responseArray,
                    [
                        'complete' => true,
                    ]
                )
            );
        }

        // Fetch the question from the database
        $questionName = array_slice(
            explode('.', $this->getSpecialMapping($question)),
            0,
            2
        );
        $existingQuestion = $this->questionService
            ->optional()
            ->findBy([
                'name' => implode('>>>', $questionName),
                'questionnaire_id' => $questionnaire->id,
            ]);
        if (is_null($existingQuestion)) {
            return;
        }

        $questionItem = $this->questionItemService
            ->optional()
            ->pushCriteria(
                new WhereCaseInsensitive(
                    'value',
                    '%'.strtolower($answer).'%'
                )
            )
            ->findBy('question_id', $existingQuestion->id);

        if ($question !== $this->getSpecialMapping($question)) {
            $specialQuestionItem = $this->questionItemService
                ->optional()
                ->findBy([
                    'name' => str_replace('.', '>>>', $this->getSpecialMapping($question)),
                    'question_id' => $existingQuestion->id,
                    'value' => null,
                ]);
        }

        $column = $this->questionGridService
            ->optional()
            ->findBy([
                'question_id' => $existingQuestion->id,
                'type' => 'C',
                'value' => $this->getCleanedField($answer),
            ]);

        $row = $this->questionGridService
            ->optional()
            ->pushCriteria(
                new WhereCaseInsensitive(
                    'value',
                    '%'.$this->getCleanedField($header).'%'
                )
            )
            ->findBy([
                'question_id' => $existingQuestion->id,
                'type' => 'R',
            ]);

        // Search for an existing answer, abort early if one is found
        $existingAnswer = $this->answerService
            ->optional()
            ->findBy([
                'column_id' => $column->id ?? null,
                'question_id' => $existingQuestion->id,
                'question_item_id' => $questionItem->id ?? null,
                'response_id' => $response->id,
                'row_id' => $row->id ?? null,
            ]);
        if (! is_null($existingAnswer)) {
            return;
        }

        $this->answerService->create([
            'column_id' => $column->id ?? null,
            'question_id' => $existingQuestion->id,
            'question_item_id' => $questionItem->id ?? $specialQuestionItem->id ?? null,
            'response_id' => $response->id,
            'row_id' => $row->id ?? null,
            'value' => $answer,
        ]);
    }

    /**
     * Processes a client, returns the client if it exists.
     *
     * @param array $client
     * @param mixed $clinic
     *
     * @return User
     */
    protected function processClientData(array $client, $clinic)
    {
        // Validate client data
        $validator = Validator::make($client, [
            'email' => 'required|filled|email',
            'name' => 'required|filled',
        ]);

        // Client data is not valid, return `null`
        if ($validator->fails()) {
            return null;
        }

        // Client data is valid, search for existing client in database by email
        $client['email'] = strtolower($client['email']);
        $user = $this->userService
            ->optional()
            ->findBy('email', $client['email']);

        // Client exists, return the existing client
        if (! is_null($user)) {
            return $user;
        }

        // Client does not exist, create a new one and return it
        $client['password'] = Hash::make(str_random(24));
        $user = $this->userService->create($client);
        if (! is_null($clinic)) {
            $this->userService->assignClinic($clinic, $user);
        }

        return $user;
    }

    /**
     * Performs a generic import.
     *
     * @param Collection $headers
     * @param Collection $data
     * @param array      $mapping
     * @param mixed      $clinic
     *
     * @return void
     */
    protected function import(Collection $headers, Collection $data, array $mapping, $clinic = null)
    {
        DB::transaction(function () use ($clinic, $headers, $data, $mapping) {
            // If a clinic is provided, attempt to load it from the database
            if (! is_null($clinic)) {
                $clinic = $this->clinicService->findBy('uuid', $clinic);
            }

            // Displays a progress bar in the console
            $output = new ConsoleOutput();
            $progress = new ProgressBar($output, $data->count());
            $progress->start();

            foreach ($data as $index => $row) {
                // Import or retrieve the existing client
                $user = $this->processClientData(
                    $this->getClientData($row, $mapping),
                    $clinic
                );
                if (is_null($user)) {
                    logger('Importer: failed to import user', [
                        'index' => $index,
                    ]);
                    $progress->advance();
                    continue;
                }

                // Save the questionnaire data to the database
                foreach ($mapping as $question => $index) {
                    if (
                        is_null($row->get($mapping[$question])) ||
                        is_null($headers->get($mapping[$question]))
                    ) {
                        continue;
                    }
                    $this->processAnswer(
                        $user,
                        $question,
                        $row->get($mapping[$question]),
                        $headers->get($mapping[$question])
                    );
                }

                // Save the data for each response to the database.  May
                // recalculate for some responses, will not change the data
                // as long as the data is up to date.
                $responses = $this->responseService
                    ->getByCriteria(new WhereEqual('user_id', $user->id))
                    ->all();
                foreach ($responses as $response) {
                    $data = $this->responseService->getJson($response);
                    $this->responseService->update($response, [
                        'clinic_id' => $clinic->id ?? null,
                        'data' => json_encode($data),
                    ]);
                }

                $progress->advance();
            }

            $progress->finish();
            $output->writeln('');
        });
    }

    /**
     * Processes users from the legacy API to ensure that the user list is up
     * to date before processing questionnaires from the Sheets API.
     *
     * @param mixed $clinic
     *
     * @return void
     */
    public function importLegacyUserData($clinic = null)
    {
        DB::transaction(function () use ($clinic) {
            $clientRole = $this->roleService->findBy('level', Roles::Client);
            $therapistRole = $this->roleService->findBy('level', Roles::SeniorTherapist);

            // If a clinic is provided, attempt to load it from the database
            if (! is_null($clinic)) {
                $clinic = $this->clinicService->findBy('uuid', $clinic);
            }

            $therapists = $this->legacyApiService->getUserData();
            $numberOfOperations = $therapists->reduce(function ($carry, $item) {
                return $carry + 1 + $item->clients->count();
            }, 0);
            $output = new ConsoleOutput();
            $progress = new ProgressBar($output, $numberOfOperations);
            $progress->start();

            foreach ($therapists as $therapist) {
                $therapistData = [
                    'email' => strtolower($therapist->email),
                    'name' => $therapist->name,
                    'password' => Hash::make(str_random(24)),
                    'role_id' => $therapistRole->id,
                ];

                // Validate therapist data
                $validator = Validator::make($therapistData, [
                    'email' => 'required|filled|email',
                    'name' => 'required|filled',
                ]);

                if ($validator->fails()) {
                    continue;
                }

                $therapistUser = $this->userService
                    ->optional()
                    ->findBy('email', $therapistData['email']);
                if (is_null($therapistUser)) {
                    $therapistUser = $this->userService->create($therapistData);
                    if (! is_null($clinic)) {
                        $this->userService->assignClinic($clinic, $therapistUser);
                    }
                }

                $therapist->clients->each(function ($client) use ($clientRole, $clinic, $progress, $therapistUser) {
                    $clientData = [
                        'email' => strtolower($client->email),
                        'name' => $client->name,
                        'password' => Hash::make(str_random(24)),
                        'phone' => $client->phone,
                        'role_id' => $clientRole->id,
                    ];

                    // Validate client data
                    $validator = Validator::make($clientData, [
                        'email' => 'required|filled|email',
                        'name' => 'required|filled',
                    ]);

                    if ($validator->fails()) {
                        return true;
                    }

                    $clientUser = $this->userService
                        ->optional()
                        ->findBy('email', $clientData['email']);
                    if (is_null($clientUser)) {
                        $clientUser = $this->userService->create($clientData);
                        if (! is_null($clinic)) {
                            $this->userService->assignClinic($clinic, $clientUser);
                        }
                    }
                    $this->userService->addTherapist($therapistUser, $clientUser);
                    $progress->advance();
                });

                $progress->advance();
            }

            $progress->finish();
            $output->writeln('');
        });
    }

    /**
     * Imports the `assess` sheet.
     *
     * @param string $language
     * @param mixed  $clinic
     *
     * @return void
     */
    public function importAssess(string $language, $clinic = null)
    {
        $data = $this->getRawCsvData(Sheets::Assess[$language]);
        $mapping = SheetsMapping::Assess[$language];

        return $this->import($data->first(), $data->slice(1), $mapping, $clinic);
    }

    /**
     * Imports the `mbct` sheet.
     *
     * @param string $language
     * @param mixed  $clinic
     *
     * @return void
     */
    public function importMbct(string $language, $clinic = null)
    {
        $data = $this->getRawCsvData(Sheets::Mbct[$language]);
        $mapping = SheetsMapping::Mbct[$language];

        return $this->import($data->first(), $data->slice(1), $mapping, $clinic);
    }

    /**
     * Imports the `mbsr` sheet.
     *
     * @param string $language
     * @param mixed  $clinic
     *
     * @return void
     */
    public function importMbsr(string $language, $clinic = null)
    {
        $data = $this->getRawCsvData(Sheets::Mbsr[$language]);
        $mapping = SheetsMapping::Mbsr[$language];

        return $this->import($data->first(), $data->slice(1), $mapping, $clinic);
    }
}
