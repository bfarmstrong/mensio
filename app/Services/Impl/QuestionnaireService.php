<?php

namespace App\Services\Impl;

use App\Services\BaseService;
use DB;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Implementation of the questionnaire service.
 */
class QuestionnaireService extends BaseService implements IQuestionnaireService
{
    /**
     * The question service.
     *
     * @var IQuestionService
     */
    protected $questionService;

    /**
     * The question grid service.
     *
     * @var IQuestionItemGridService
     */
    protected $questionGridService;

    /**
     * The question item service.
     *
     * @var IQuestionItemService
     */
    protected $questionItemService;

    /**
     * Creates an instance of `QuestionnaireService`.
     *
     * @param Container            $container
     * @param Collection           $criteria
     * @param IQuestionService     $questionService
     * @param IQuestionGridService $questionGridService
     * @param IQuestionItemService $questionItemService
     */
    public function __construct(
        Container $container,
        Collection $criteria,
        IQuestionService $questionService,
        IQuestionGridService $questionGridService,
        IQuestionItemService $questionItemService
    ) {
        parent::__construct($container, $criteria);

        $this->questionService = $questionService;
        $this->questionGridService = $questionGridService;
        $this->questionItemService = $questionItemService;
    }

    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Questionnaire::class;
    }

    /**
     * Imports a questionnaire from a JSON input.  Returns the created
     * questionnaire object.
     *
     * @param mixed $data
     * @param mixed $options
     *
     * @return Model
     */
    public function importFromJson($data, $options = null)
    {
        return DB::transaction(function () use ($data, $options) {
            $rawData = $data;
            $questionnaire = $this->create([
                'data' => json_encode($rawData),
                'name' => $options['name'] ?? $data->pages[0]->name,
                'scoring_method' => $options['scoring_method'] ?? null,
            ]);

            foreach ($data->pages as $page) {
                foreach ($page->elements as $element) {
                    $question = $this->questionService->create([
                        'label' => $element->title ?? $element->html,
                        'name' => $element->name,
                        'questionnaire_id' => $questionnaire->id,
                        'type' => $element->type,
                    ]);

                    $choices = collect(
                        $element->choices ??
                        $element->items ??
                        []
                    );

                    // Add each choice as a question item
                    foreach ($choices as $index => $choice) {
                        $questionItem = $this->questionItemService->create([
                            'label' => $choice->title ?? $choice->name ?? $choice->text ?? null,
                            'name' => $choice->name ?? $element->name,
                            'question_id' => $question->id,
                            'score' => $element->scores[$index] ?? null,
                            'value' => is_string($choice) ?
                                $choice :
                                $choice->value ?? null,
                        ]);
                    }

                    $columns = collect($element->columns ?? []);
                    $rows = collect($element->rows ?? []);

                    // Add the columns to the database
                    foreach ($columns as $index => $column) {
                        $this->questionGridService->create([
                            'index' => $index,
                            'question_id' => $question->id,
                            'score' => $element->scores[$index] ?? null,
                            'type' => 'C',
                            'value' => $column,
                        ]);
                    }

                    // Add the rows to the database
                    foreach ($rows as $index => $row) {
                        $this->questionGridService->create([
                            'index' => $index,
                            'question_id' => $question->id,
                            'type' => 'R',
                            'value' => $row,
                        ]);
                    }
                }
            }

            return $questionnaire;
        });
    }
}
