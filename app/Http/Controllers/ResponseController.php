<?php

namespace App\Http\Controllers;

use App\Http\Requests\Response\UpdateDataRequest;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IClinicService;
use App\Services\Impl\IResponseService;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Config;
/**
 * Controller which handles unauthenticated access to questionnaires.
 */
class ResponseController extends Controller
{
    /**
     * The response service implementation.
     *
     * @var IResponseService
     */
    protected $response;

	/**
     * The clinic service implementation.
     *
     * @var IClinicService
     */
	protected $clinicservice;

    /**
     * Creates an instance of `ResponseController`.
     *
     * @param IResponseService $response
     */
    public function __construct(IResponseService $response,IClinicService $clinicservice)
    {
        $this->response = $response;
		$this->clinicservice = $clinicservice;
    }

    /**
     * Shows the user their list of responses.
     *
     * @return void
     */
    public function index()
    {
        $this->authorize('index', \App\Models\Response::class);
		$clinic_id = request()->attributes->get('clinic')->id;
        $responses = $this->response
            ->pushCriteria(new WhereAssigned(Auth::id()))
            ->pushCriteria(new WithQuestionnaire())
			->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
            ->paginate();

        return view('responses.index', [
            'responses' => $responses,
        ]);
    }

    /**
     * Displays the page for the questionnaire.
     *
     * @param string $response
     *
     * @return Response
     */
    public function show(string $response)
    {
        $response = $this->response
            ->getByCriteria(new WithQuestionnaire())
            ->findBy('uuid', $response);

        if (is_null($response)) {
            abort(404);
        }

        return view('responses.show', ['response' => $response]);
    }

    /**
     * Displays a questionnaire to the client so that they can complete it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function showExternal(Request $request)
    {
        // Ensure that the request signature is valid
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $response = $this->response
            ->getByCriteria(new WithQuestionnaire())
            ->findBy('uuid', $request->response_id);

        if (is_null($response)) {
            abort(404);
        }

        return view('responses.show-external', ['response' => $response]);
    }

    /**
     * Updates the data for a response.
     *
     * @param UpdateDataRequest $request
     *
     * @return Response
     */
    public function updateData(UpdateDataRequest $request)
    {
        // Ensure that the request signature is valid
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $response = $this->response->findBy('uuid', $request->response_id);
        if (is_null($response)) {
            abort(404);
        }

        DB::transaction(function () use ($request, $response) {
            $this->response->answer($response->id, $request->get('data'));
        });

        return redirect()
            ->back()
            ->with('message', __('responses.index.questionnaire-complete'));
    }
}
