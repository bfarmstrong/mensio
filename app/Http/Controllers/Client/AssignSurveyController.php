<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Questionnaire;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\ISurveyService;
use App\Services\Impl\IUserService;
use App\Services\Impl\IQuestionnaireService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\SurveyCreateRequest;
/**
 * Manages administrative actions against survey.
 */
class AssignSurveyController extends Controller
{
	/**
     * The questionnaire service implementation.
     *
     * @var IQuestionnaireService
     */
    protected $questionnaire;
	
    /**
     * The service implementation for survey.
     *
     * @var ISurveyService
     */
    protected $survey;
	
	 /**
     * The service implementation for user.
     *
     * @var IUserService
     */
    protected $user;

    /**
     * Creates an instance of `SurveyController`.
     *
     * @param ISurveyService $service
     */
    public function __construct(ISurveyService $survey, IUserService $user,IQuestionnaireService $questionnaire)
    {
        $this->survey = $survey;
        $this->user = $user;
		$this->questionnaire = $questionnaire;
    }

	public function assign(string $client,Request $request)
	{
		$client = $this->user->find($client);
		$all_surveys = $request->user()->surveys()->pluck('name','id');
		return view('clients.surveys.assign')->with([
            'user' => $client,
            'all_surveys' => $all_surveys,
        ]);
	}
	
	public function postassign()
	{
	
	}

}
