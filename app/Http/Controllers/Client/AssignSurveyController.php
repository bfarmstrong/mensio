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
use App\Services\Impl\IResponseService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\SurveyCreateRequest;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WithRelation;
/**
 * Manages administrative actions against survey.
 */
class AssignSurveyController extends Controller
{
	/**
     * The response service implementation.
     *
     * @var IResponseService
     */
    protected $response;
	
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
    public function __construct(ISurveyService $survey, IUserService $user,IQuestionnaireService $questionnaire,IResponseService $response)
    {
        $this->survey = $survey;
        $this->user = $user;
		$this->questionnaire = $questionnaire;
		$this->response = $response;
    }
	
	public function index(Request $request, string $client)
	{
		$client = $this->user->find($client);
		$surveys = $client->user_surveys()->paginate();
		return view('clients.surveys.index')->with([
                'surveys' => $surveys,
				'client' => $client
            ]);
	}
	public function assign(string $client,Request $request)
	{
		$client = $this->user->find($client);
		$surveys = $this->survey->all();
		foreach($surveys as $survey){
			$all_surveys[$survey->id] = $survey->name;
		}
		return view('clients.surveys.assign')->with([
            'user' => $client,
            'all_surveys' => $all_surveys,
        ]);
	}
	
	public function postassign(string $client,Request $request)
	{ 
		$client = $this->user->find($client);
		$client->user_surveys()->sync($request->survey_id, false);

		$this->response->assignSurveyToClient(
			$client->id,
			$request->survey_id
				
		);

		return redirect("clients/$client->id/surveys/assign")->with([
            'message' => __('admin.surveys.assignsurvey.user-assigned'),
        ]);
	}

}
