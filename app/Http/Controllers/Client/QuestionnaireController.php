<?php

namespace App\Http\Controllers\Client;

use App\Exceptions\NoAvailableQuestionnairesException;
use App\Http\Controllers\Controller;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\Questionnaire\WhereNotAssigned;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Handles actions related to the client questionnaire management.
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
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;

    /**
     * The clinic service implementation.
     *
     * @var IClinicService
     */
    protected $clinicservice;

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
        IUserService $user,
        IClinicService $clinicservice
    ) {
        $this->questionnaire = $questionnaire;
        $this->response = $response;
        $this->user = $user;
        $this->clinicservice = $clinicservice;
    }

    /**
     * Displays the page to assign a questionnaire to a client.
     *
     * @param string $user
     *
     * @return Response
     */
    public function create(string $user)
    {
        $user = $this->user->find($user);
        $this->authorize('addQuestionnaire', $user);

        $questionnaires = $this->questionnaire
            ->getByCriteria(new WhereNotAssigned($user->id))
            ->all();

        if ($questionnaires->isEmpty()) {
            throw new NoAvailableQuestionnairesException();
        }

        return view('clients.questionnaires.create')->with([
            'questionnaires' => $questionnaires,
            'user' => $user,
        ]);
    }

    /**
     * Unassigns a questionnaire from a client.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function destroy(Request $request)
    {
        $user = $this->user->find($request->user_id);
        $this->authorize('removeQuestionnaire', $user);

        $this->response->unassignFromClient(
            $user->id,
            $request->questionnaire_id
        );

        return redirect()
            ->back()
            ->with('message', __('clients.show.questionnaire-unassigned'));
    }

    /**
     * Displays a page with the list of questionnaires that a client has
     * been assigned.
     *
     * @param string $user
     *
     * @return Response
     */
    public function index(string $user)
    {
        $user = $this->user->find($user);
        $this->authorize('viewQuestionnaires', $user);
        $clinic_id = request()->attributes->get('clinic')->id;
        $responses = $this->response
            ->getByCriteria(new WithRelation('questionnaire'))
            ->getByCriteria(new OrderBy('updated_at', 'desc'))
            ->getByCriteria(new WhereAssigned($user->id))
            ->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
            ->paginate();

        return view('clients.questionnaires.index')->with([
            'responses' => $responses,
            'user' => $user,
        ]);
    }

    /**
     * Returns the view with the questionnaire for a specific client.
     *
     * @param string $user
     * @param string $response
     *
     * @return Response
     */
    public function show(string $user, string $response)
    {
        $user = $this->user->find($user);
        $this->authorize('viewQuestionnaires', $user);

        $response = $this->response
            ->getByCriteria(new WithQuestionnaire())
            ->findBy('uuid', $response);
        $score = $this->response->getScore($response);

        return view('clients.questionnaires.show', [
            'response' => $response,
            'score' => $score,
            'user' => $user,
        ]);
    }

    /**
     * Assigns a questionnaire to a client.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = $this->user->find($request->user_id);
        $this->authorize('addQuestionnaire', $user);

        $this->response->assignToClient(
            $user->id,
            $request->get('questionnaire_id')
        );

        return redirect()
            ->to(url("clients/$request->user_id/questionnaires"))
            ->with('message', __('clients.show.questionnaire-assigned'));
    }
}
