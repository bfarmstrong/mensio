<?php

namespace App\Services\Impl;

use App\Exceptions\QuestionnaireAlreadyAssignedException;
use App\Exceptions\QuestionnaireAlreadyCompletedException;
use App\Services\BaseService;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\Questionnaire\WithQuestionsAndItems;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Implementation of the response service.
 */
class ResponseService extends BaseService implements IResponseService
{
    /**
     * The answer service implementation.
     *
     * @var IAnswerService
     */
    protected $answerService;

    /**
     * The questionnaire service implementation.
     *
     * @var IQuestionnaireService
     */
    protected $questionnaireService;

    /**
     * Creates an instance of `ResponseService`.
     *
     * @param Container             $container
     * @param Collection            $criteria
     * @param IAnswerService        $answerService
     * @param IQuestionnaireService $questionnaireService
     */
    public function __construct(
        Container $container,
        Collection $criteria,
        IAnswerService $answerService,
        IQuestionnaireService $questionnaireService
    ) {
        parent::__construct($container, $criteria);

        $this->answerService = $answerService;
        $this->questionnaireService = $questionnaireService;
    }

    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\Response::class;
    }

    /**
     * Fills out the answers for a response.
     *
     * @param mixed  $response
     * @param string $answers
     *
     * @return Model
     */
    public function answer($response, string $answers)
    {
        $this->update($response, [
            'complete' => true,
            'data' => $answers,
        ]);

        $response = $this->find($response);
        $questionnaire = $this->questionnaireService
            ->getByCriteria(new WithQuestionsAndItems())
            ->find($response->questionnaire_id);

        foreach (json_decode($answers) as $name => $answer) {
            $question = $questionnaire->questions
                ->where('name', $name)
                ->first();

            $this->answerService->updateOrCreate(
                $response->id,
                $question->id,
                $question->questionItems
                    ->where('value', $answer)
                    ->first()
                    ->id ?? null,
                $answer
            );
        }

        return $response;
    }

    /**
     * Assigns a questionnaire to a client.
     *
     * @param mixed $client
     * @param mixed $questionnaire
     *
     * @return Model
     */
    public function assignToClient($client, $questionnaire)
    {
        $assigned = $this
            ->optional()
            ->findBy([
                ['questionnaire_id', $questionnaire],
                ['user_id', $client],
            ]);

        // Prevent assignment of a questionnaire if it is already assigned
        if (! is_null($assigned)) {
            throw new QuestionnaireAlreadyAssignedException();
        }

        return $this->create([
            'questionnaire_id' => $questionnaire,
            'user_id' => $client,
        ]);
    }

    /**
     * Converts a response into its array equivalent.
     *
     * @param mixed $response
     *
     * @return array
     */
    public function getJson($response)
    {
        $response = $this->find($response);

        $answers = $this->answerService
            ->pushCriteria(new WhereEqual('response_id', $response->id))
            ->pushCriteria(new WithRelation('column'))
            ->pushCriteria(new WithRelation('question'))
            ->pushCriteria(new WithRelation('questionItem'))
            ->pushCriteria(new WithRelation('row'))
            ->all();

        $json = collect();
        $answers->each(function ($answer) use ($json) {
            if (
                is_null($answer->column) &&
                is_null($answer->row) &&
                ! is_null($answer->questionItem->value ?? null) &&
                (
                    ! is_null($answer->questionItem) ||
                    ! is_null($answer->value)
                )
            ) {
                $json->put($answer->question->name, $answer->value);

                return;
            }

            $data = $json->get($answer->question->name) ?? collect();
            $key = $answer->row->value ?? null;
            $value = $answer->column->value ?? $answer->questionItem->value ?? $answer->value;

            if (
                is_null($key) &&
                $answer->question->name === ($answer->questionItem->name ?? $answer->question->name)
            ) {
                $json->put($answer->question->name, $data->push($value));

                return;
            }

            $data->put($answer->questionItem->name ?? $key, $value);
            $json->put($answer->question->name, $data);
        });

        return $json->toArray();
    }

    /**
     * Retrieves the score for a response.
     *
     * @param mixed $response
     *
     * @return int
     */
    public function getScore($response)
    {
        $response = $this->find($response);
        if (! $response->complete) {
            return null;
        }

        $questionnaire = $this->questionnaireService
            ->getByCriteria(new WithQuestionsAndItems())
            ->find($response->questionnaire_id);

        $scores = $questionnaire->questions->map(function ($question) use ($response) {
            $answer = $question
                ->answers()
                ->where('response_id', $response->id)
                ->first();

            if (is_null($answer)) {
                return null;
            }

            if (! is_null($answer->questionItem)) {
                return $answer->questionItem->score ?? null;
            }

            $answers = collect(json_decode($answer->value));

            return $answers->map(function ($value, $key) use ($question) {
                $answer = $question->questionGrid()->where('value', $value)->first();

                return $answer->score ?? null;
            });
        });

        switch ($questionnaire->scoring_method) {
            case 'sum':
                return $scores->flatten()->sum();
        }
    }

    /**
     * Removes a response from a client.
     *
     * @param mixed $client
     * @param mixed $questionnaire
     *
     * @return int
     */
    public function unassignFromClient($client, $questionnaire)
    {
        $response = $this->findBy([
            ['questionnaire_id', $questionnaire],
            ['user_id', $client],
        ]);

        if ($response->complete) {
            throw new QuestionnaireAlreadyCompletedException();
        }

        return $this->delete($response->id);
    }
}
