<?php

namespace App\Http\Controllers\Group;

use App\Exceptions\NoAvailableQuestionnairesException;
use App\Http\Controllers\Controller;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\User\WithRole;
use App\Services\Criteria\Questionnaire\GroupWhereNotAssigned;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Group;

/**
 * Handles actions related to the group questionnaire management.
 */
class GroupQuestionnaireController extends Controller
{
    /**
     * The questionnaire service implementation.
     *
     * @var IQuestionnaireService
     */
    protected $questionnaire;

    /**
     * The response service implementation.
     *
     * @var IResponseService
     */
    protected $response;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $group;

    /**
     * Creates an instance of `ClientController`.
     *
     * @param IQuestionnaireService $questionnaire
     * @param IResponseService      $response
     * @param IUserService          $user
     */
    public function __construct(
        IQuestionnaireService $questionnaire,
        IResponseService $response,
        IGroupService $group,
        IUserService $user
    ) {
        $this->questionnaire = $questionnaire;
        $this->response = $response;
        $this->group = $group;
        $this->user = $user;
    }

    /**
     * Displays the page to assign a questionnaire to a group.
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function create(string $uuid)
    {
        $group = $this->group->findBy('uuid', $uuid);

        $questionnaires = $this->questionnaire->all();

        if ($questionnaires->isEmpty()) {
            throw new NoAvailableQuestionnairesException();
        }

        return view('admin.groups.questionnaires.create')->with([
            'questionnaires' => $questionnaires,
            'group' => $group,
        ]);
    }

    /**
     * Assigns a questionnaire to a group.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
		if ($request->is_submit == 0) {
		$clients = $this->user
				->pushCriteria(new WhereClient())
				->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
				->pushCriteria(new WithRole())
				->all();

			foreach($clients as $client){
				$this->response->assignToClient(
					$client->id,
					$request->get('questionnaire_id'),
					true
				);
			}
        return redirect()
            ->back()
            ->with('message', __('groups.show.questionnaire-assigned'));
	   }
	   if ($request->is_submit == 1) {
		   $clients = $this->user
				->pushCriteria(new WhereClient())
				->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
				->pushCriteria(new WithRole())
				->all();

			foreach($clients as $client){
				$this->response->unassignFromClient(
					$client->id,
					$request->get('questionnaire_id'),
					true
				);
			}

        return redirect()
            ->back()
            ->with('message', __('groups.show.questionnaire-unassigned'));
	   }
    }


}
