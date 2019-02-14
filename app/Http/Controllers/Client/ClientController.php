<?php

namespace App\Http\Controllers\Client;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SearchClientRequest;
use App\Models\User;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IQuestionnaireService;
use App\Services\Impl\IResponseService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Response;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use Yajra\Datatables\Datatables;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\INoteService;
use App\Services\Criteria\Note\WhereParent;
use App\Services\Criteria\Note\WithTherapist;
use App\Services\Criteria\User\WithSupervisors;
use App\Services\Criteria\User\WhereTherapist;
use App\Services\Criteria\User\WhereNotCurrentTherapist;
use App\Services\Criteria\User\WithTherapistsAndSupervisors;
/**
 * Manages a list of clients.
 */
class ClientController extends Controller
{
	/**
     * The note service implementation.
     *
     * @var INoteService
     */
    protected $noteService;
	
	/**
     * The communication log service implementation.
     *
     * @var ICommunicationLogService
     */
    protected $communicationLogService;
	
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
        IUserService $user,
		INoteService $noteService,
		ICommunicationLogService $communicationLogService
    ) {
        $this->questionnaire = $questionnaire;
        $this->response = $response;
        $this->user = $user;
		$this->communicationLogService = $communicationLogService;
		$this->noteService = $noteService;
    }

    /**
     * Displays the page to add clients to a user.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewClients', User::class);
        $query = $this->user
            ->pushCriteria(new WhereRelationEqual('roles', 'level', Roles::Client))
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRelation('roles'));

        // Data tables support.  Utilizes the existing query.
        if (request()->expectsJson()) {
            $query->applyCriteria();

            return DataTables::of($query->getModel())->toJson();
        }

        return view('clients.index')->with([
            'clients' => $query->paginate(),
        ]);
    }

    /**
     * Performs a search for a client by their name.
     *
     * @param SearchClientRequest $request
     *
     * @return Response
     */
    public function search(SearchClientRequest $request)
    {
        $this->authorize('viewClients', User::class);

        if (! $request->search) {
            return redirect('clients');
        }

        $clients = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRole())
            ->search($request->get('search'));

        if ($clients->isNotEmpty()) {
            if (1 === $clients->count()) {
                $user = $clients->first();

                return redirect("clients/$user->id");
            }

            return view('clients.index')->with([
                'clients' => $clients,
            ]);
        }

        return redirect()->back()->withErrors([
            __('clients.index.no-search-results'),
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
        $client = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRole())
            ->find($user);
        $this->authorize('view', $client);

        return view('clients.show')->with([
            'user' => $client,
        ]);
    }
	 
	/**
     * Displays the chart for a client's information. 
     * 
     *
     * @param string $user
     *
     * @return Response
    */
	public function charts(string $user)
	{
		$client = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRole())
            ->find($user);
        $this->authorize('view', $client);
		$clinic_id = request()->attributes->get('clinic')->id;
        $responses = $this->response
            ->pushCriteria(new WithRelation('questionnaire'))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->pushCriteria(new WhereAssigned(\Auth::user()->id))
            ->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
			->all();
		foreach($responses as $response) {
		    $response_details = $this->response
				->getByCriteria(new WithQuestionnaire())
				->findBy('uuid', $response->uuid);
			$score[$response->uuid] = $this->response->getScore($response_details);
		}
		return view('clients.charts.show')->with([
				'user' => $client,
				'score' => $score,
				'responses' => $responses
			]);
	}
	
	/**
     * Displays the details for a client's information. 
     * 
     *
     * @param string $user
     *
     * @return Response
    */
	public function details(string $user)
	{
			$client = $this->user->find($user);
			$clinic_id = request()->attributes->get('clinic')->id;
			$score = array();
			$responses = $this->response
				->getByCriteria(new WithRelation('questionnaire'))
				->getByCriteria(new OrderBy('updated_at', 'desc'))
				->getByCriteria(new WhereAssigned($user))
				->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
				->all();
			foreach($responses as $response) {
				$response_details = $this->response
					->getByCriteria(new WithQuestionnaire())
					->findBy('uuid', $response->uuid);
				$score[$response->uuid] = $this->response->getScore($response_details);
			}
			
			$user_therapists = $this->user
				->getByCriteria(new WithTherapistsAndSupervisors($user))
				->find($user); 
			$therapists	= '';
			foreach($user_therapists->therapists()->pluck('name') as $name_therapist) {
				$therapists	.= $name_therapist.',';
			}
			$communication = $this->communicationLogService
				->pushCriteria(new WhereEqual('clinic_id', request()->attributes->get('clinic')->id))
				->pushCriteria(new WhereEqual('user_id', $client->id))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->all();
				
			$notes = $this->noteService
				->pushCriteria(new WhereEqual('client_id', $client->id))
				->pushCriteria(new WhereParent())
				->pushCriteria(new WithTherapist())
				->pushCriteria(new WhereEqual('is_draft', 0))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->all();
		return view('clients.brief')->with([
				'user' => $client,
				'scores' => $score,
				'communication' => $communication,
				'notes' => $notes,
				'responses' => $responses,
				'therapists' => rtrim($therapists,','),
			]);
	}
	
}
