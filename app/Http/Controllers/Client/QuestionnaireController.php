<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
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
     * @param IResponseService $response
     * @param IUserService     $user
     */
    public function __construct(IResponseService $response, IUserService $user)
    {
        $this->response = $response;
        $this->user = $user;
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
        $this->response->unassignFromClient(
            $request->user_id,
            $request->questionnaire_id
        );

        return redirect()
            ->back()
            ->with('message', __('clients.show.questionnaire-unassigned'));
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
        if (is_null($user)) {
            abort(404);
        }

        $response = $this->response
            ->getByCriteria(new WithQuestionnaire())
            ->findBy('uuid', $response);

        if (is_null($response)) {
            abort(404);
        }

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
        $this->response->assignToClient(
            $request->user_id,
            $request->get('questionnaire_id')
        );

        return redirect()
            ->back()
            ->with('message', __('clients.show.questionnaire-assigned'));
    }
}
