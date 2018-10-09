<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\Questionnaire\WhereNotAssigned;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Response;

/**
 * Manages a list of clients.
 */
class ClientController extends Controller
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
     * Creates an instance of `ClientController`.
     *
     * @param IUserService $user
     */
    public function __construct(
        IQuestionnaireService $questionnaire,
        IResponseService $response,
        IUserService $user
    ) {
        $this->questionnaire = $questionnaire;
        $this->response = $response;
        $this->user = $user;
    }

    /**
     * Displays the page to add clients to a user.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewClients', User::class);
        $clients = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRole())
            ->paginate();

        return view('clients.index')->with([
            'clients' => $clients,
        ]);
    }

    /**
     * Displays the page for a single client's information.  The client must be
     * a client of the current user.
     *
     * @param string $user
     *
     * @return Response
     */
    public function show(string $user)
    {
        $this->authorize('viewClients', User::class);

        $client = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRole())
            ->find($user);
        if (is_null($user)) {
            abort(404);
        }

        $unassignedQuestionnaires = $this->questionnaire
            ->getByCriteria(new WhereNotAssigned($user))
            ->all();

        $assignedResponses = $this->response
            ->pushCriteria(new WithQuestionnaire())
            ->pushCriteria(new WhereAssigned($user))
            ->all();

        return view('clients.show')->with([
            'questionnaires' => [
                'assigned' => $assignedResponses,
                'unassigned' => $unassignedQuestionnaires,
            ],
            'user' => $client,
        ]);
    }
}
