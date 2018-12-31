<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\ManageQuestionnairesRequest;
use App\Models\Group;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handles actions related to the group questionnaire management.
 */
class QuestionnaireController extends Controller
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
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $group;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;

    /**
     * Creates an instance of `ClientController`.
     *
     * @param IQuestionnaireService $questionnaire
     * @param IResponseService      $response
     * @param IGroupService         $group
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
        $responses = $this->response
            ->getByCriteria(new WhereEqual('group_id', $group->id))
            ->paginate();

        return view('admin.groups.questionnaires.create')->with([
            'group' => $group,
            'questionnaires' => $questionnaires,
            'responses' => $responses,
        ]);
    }

    /**
     * Returns the view with the questionnaire for a specific client.
     *
     * @param string $group
     * @param string $response
     *
     * @return Response
     */
    public function show(string $group, string $response)
    {
        $group = $this->group->findBy('uuid', $group);
        $response = $this->response
            ->getByCriteria(new WithRelation('questionnaire'))
            ->findBy('uuid', $response);
        $score = $this->response->getScore($response);

        return view('admin.groups.questionnaires.show', [
            'group' => $group,
            'response' => $response,
            'score' => $score,
        ]);
    }

    /**
     * Assigns a questionnaire to a group.
     *
     * @param ManageQuestionnairesRequest $request
     * @param string                      $uuid
     *
     * @return Response
     */
    public function store(ManageQuestionnairesRequest $request, string $uuid)
    {
        $group = $this->group->findBy('uuid', $uuid);
        $clients = $this->group->findClients($group);
        $submit = (bool) $request->is_submit;

        foreach ($clients as $client) {
            $response = $this->response->optional()->findBy([
                'group_id' => $group->id,
                'questionnaire_id' => $request->get('questionnaire_id'),
            ]);

            if (is_null($response) && $submit) {
                $this->response->create([
                    'clinic_id' => $request->attributes->get('clinic')->id,
                    'group_id' => $group->id,
                    'questionnaire_id' => $request->get('questionnaire_id'),
                    'user_id' => $client->id,
                ]);
            } elseif (! is_null($response) && ! $submit) {
                $this->response->delete($response);
            }
        }

        $message = $submit ?
            __('groups.show.questionnaire-assigned') :
            __('groups.show.questionnaire-unassigned');

        return redirect()
            ->back()
            ->with('message', $message);
    }
}
