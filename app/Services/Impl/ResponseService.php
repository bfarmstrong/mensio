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
use App\Services\Impl\ISurveyService;

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
     * The service implementation for survey.
     *
     * @var ISurveyService
     */
    protected $survey;
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
        IQuestionnaireService $questionnaireService,
		ISurveyService $survey
    ) {
        parent::__construct($container, $criteria);

        $this->answerService = $answerService;
        $this->questionnaireService = $questionnaireService;
		$this->survey = $survey;
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
			if (!is_null($question)) {
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
        }

        return $response;
    }
	
    public function answersurvey($survey, string $answers)
    {
		$model = app($this->model()); 

		foreach (json_decode($answers) as $key => $answer) {
			$response = $this->model->where([['survey_id','=',$survey],['user_id','=',\Auth::user()->id],['uuid','=',$key]])->first();
			$response = $this->answer($response->id,$answer);
		} 
        /* 
		dd(json_decode($answers));
		foreach($response as $r){
			$this->model->where('questionnaire_id',$r->questionnaire_id)->update([
					'complete' => true,
					'data' => $answers,
				]);
			$questionnaire = $this->questionnaireService
				->getByCriteria(new WithQuestionsAndItems())
				->find($r->questionnaire_id);
		
			foreach (json_decode($answers) as $name => $answer) {
				
					$question = $questionnaire->questions
						->where('name', $name)
						->first();
				if (!is_null($question)) {
				
					$this->answerService->updateOrCreate(
						$r->id,
						$question->id,
						$question->questionItems
							->where('value', $answer)
							->first()
							->id ?? null,
						$answer
					);
				}
			}
		}
        return $response; */
    }
    /**
     * Assigns a questionnaire to a client.
     *
     * @param mixed $client
     * @param mixed $questionnaire
     *
     * @return Model
     */
    public function assignToClient($client, $questionnaire, $assignfromgroup = false)
    {
        $assigned = $this
            ->optional()
            ->findBy([
                ['questionnaire_id', $questionnaire],
                ['user_id', $client],
            ]);
        if (true == $assignfromgroup && ! is_null($assigned)) {
            return false;
        } else {
            // Prevent assignment of a questionnaire if it is already assigned
            if (! is_null($assigned)) {
                throw new QuestionnaireAlreadyAssignedException();
            }
            if (! is_null(request()->attributes->get('clinic'))) {
                $clinic_id = request()->attributes->get('clinic')->id;

                return $this->create([
                    'questionnaire_id' => $questionnaire,
                    'user_id' => $client,
                    'clinic_id'=>$clinic_id,
                ]);
            } else {
                return $this->create([
                    'questionnaire_id' => $questionnaire,
                    'user_id' => $client,
                ]);
            }
        }
    }
	/**
     * Assigns a questionnaire survey to a client.
     *
     * @param mixed $client
     * @param mixed $questionnaire
     *
     * @return Model
     */
    public function assignSurveyToClient($client, $survey , $assignfromgroup = false)
    {
		$all_surveys = $this->survey->find($survey);
		foreach ($all_surveys->questionnaires()->get() as $all_survey) {
			$questionnaire = $all_survey->pivot->questionnaire_id;
			$assigned = $this
				->optional()
				->findBy([
					['questionnaire_id', $questionnaire],
					['user_id', $client],
				]);
			if (is_null($assigned)) {
				if (! is_null(request()->attributes->get('clinic'))) {
					$clinic_id = request()->attributes->get('clinic')->id;

					$this->create([
						'questionnaire_id' => $questionnaire,
						'user_id' => $client,
						'survey_id' => $survey,
						'clinic_id'=>$clinic_id,
					]);
				} else {
					$this->create([
						'questionnaire_id' => $questionnaire,
						'user_id' => $client,
						'survey_id' => $survey,
					]);
				}
			}
		}
		return true;
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
                if (! $data instanceof Collection) {
                    $data = collect([$data]);
                }
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
    public function unassignFromClient($client, $questionnaire, $assignfromgroup = false)
    {
        $response = $this->findBy([
            ['questionnaire_id', $questionnaire],
            ['user_id', $client],
        ]);
        if (true == $assignfromgroup && $response->complete) {
            return false;
        } else {
            if ($response->complete) {
                throw new QuestionnaireAlreadyCompletedException();
            }

            return $this->delete($response->id);
        }
    }
}
