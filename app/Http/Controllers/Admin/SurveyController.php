<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Questionnaire;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\ISurveyService;
use App\Services\Impl\IUserService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IQuestionnaireService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\SurveyCreateRequest;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Criteria\General\WhereIn;
use App\Services\Criteria\Questionnaire\WithQuestionsAndItems;
/**
 * Manages administrative actions against survey.
 */
class SurveyController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
		$surveys = $request->user()->surveys()->paginate();

        return view('admin.surveys.index')->with([
                'surveys' => $surveys,
            ]);
    }

    /**
     * Display a listing of the resource searched.
     *
     * @return Response
     */
    public function search(Request $request)
    {
		if (! $request->search) {
            return redirect('admin/surveys');
        }
		$surveys = $this->survey->search($request->search);
		
		return view('admin.surveys.index')->with([
            'surveys' => $surveys,
        ]);
    }

    /**
     * Show the form for creating a survey.
     *
     * @return Response
     */
    public function create()
    {
        $questionnaires = $this->questionnaire->all();

        return view('admin.surveys.create')->with([
            'questionnaires' => $questionnaires,
        ]);
    }

    /**
     * Show the form for inviting a customer.
     *
     * @return Response
     */
    public function store(SurveyCreateRequest $request)
    {
		$r = $this->survey->create($request->except(['_token', '_method']));
        foreach ($request->questionnaire_id as $questionnaire_id) {
            $questionnaire = Questionnaire::find($questionnaire_id);
            $questionnaire->surveys()->attach($r->id);
        }

        return redirect('admin/surveys')->with([
                'message' => __('admin.surveys.index.created-survey'),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit(string $id)
    {        
		$survey = $this->survey->findBy('id', $id);
        $users_id = $survey->users()->pluck('id');
		$questionnaires = $this->questionnaire->all();
		if ($questionnaires->isEmpty()) {
            throw new NoAvailableQuestionnairesException();
        }
        return view('admin.surveys.edit')->with([
            'survey' => $survey,
            'questionnaires' => $questionnaires,
            'users_id' => $users_id,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string  $id
     *
     * @return Response
     */
    public function update(Request $request, string $id)
    {
		$survey = $this->survey->findBy('id', $id);

        $this->survey->update(
            $survey->id,
            $request->except(['_token', '_method'])
        );
        $questionnaires = $survey->questionnaires()->get();
        foreach ($questionnaires as $questionnaire) {
            $survey->questionnaires()->detach($questionnaire->id);
        }
		
		foreach ($request->questionnaire_id as $questionnaire_id) {
            $questionnaire = Questionnaire::find($questionnaire_id);
            $questionnaire->surveys()->attach($survey->id);
        }
        return back()->with([
            'message' => __('admin.surveys.index.updated-survey'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy(string $id, Request $request)
    {
		$survey = $this->survey->findBy('id', $id);
		$questionnaires = $survey->questionnaires()->get();
		foreach ($questionnaires as $questionnaire) {
            $survey->questionnaires()->detach($questionnaire->id);
        }
		$this->survey->delete($id);
			
		return redirect('admin/surveys')->with([
            'message' => __('admin.surveys.index.deleted-survey'),
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $uuid
     *
     * @return Response
     */
	public function MultipleResponse(string $uuid)
	{
		$survey = $this->survey->findBy('uuid', $uuid);
		$questionnaires = $survey->questionnaires()->get();
		$ques = array();
		foreach($questionnaires  as $questionnaire) {
			$ques[] = $questionnaire->id;
		}
		$responses = $this->response
            ->pushCriteria(new WithQuestionnaire())
			->getByCriteria(new WhereIn('questionnaire_id', $ques))
            ->all(); 
		//if(empty($responses)) {
		/* 	$responses = $this->questionnaire
				->getByCriteria(new WithQuestionsAndItems())
				->getByCriteria(new WhereIn('id', $ques))
				->paginate(); */
		//}	
		return view('responses.show-multiple', ['responses' => $responses]);
	}
}
