<?php
namespace App\Http\Controllers;
use Notification;
use App\Notifications\ConsentEmail;
use App\Services\Impl\IUserService;
use App\Services\Impl\IResponseService;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\Questionnaire\WhereAssigned;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\Questionnaire\WithQuestionnaire;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\INoteService;
use App\Services\Criteria\Note\WhereClient;
use App\Services\Criteria\Note\WhereParent;
use App\Services\Criteria\Note\WithTherapist;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Enums\Roles;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\User\WhereCurrentClientSupervisorsorTherapist;
use App\Services\Criteria\User\WithTherapistsAndSupervisors;

class PagesController extends Controller
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
    protected $userService;
	
	/**
     * Creates an instance of `NoteController`.
     * @param ICommunicationLogService $communicationLogService
	 * @param INoteService             $noteService
     * @param IUserService             $userService
     */
    public function __construct(IResponseService $response,
	IUserService $userService,
	INoteService $noteService,
	ICommunicationLogService $communicationLogService
	){
		
        $this->communicationLogService = $communicationLogService;
		$this->response = $response;
		$this->noteService = $noteService;
        $this->userService = $userService;
    }
	
    /**
     * Homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return redirect('dashboard');
    }
    /**
     * Dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
		if(\Auth::user()->isTherapist()) {
			$communications =array();
			$client_names =array();
			$notes =array();
			$all_therapist_supervisor = $this->userService
				->pushCriteria(new WhereRelationEqual('roles', 'level', Roles::Client))
				->getByCriteria(new WhereCurrentClientSupervisorsorTherapist(\Auth::user()->id))
				->pushCriteria(new WithRelation('roles'))
				->all();
			
			foreach($all_therapist_supervisor as $therapist_supervisor) {	
				
					$clients = $this->userService
						->pushCriteria(new WhereRelationEqual('roles', 'level', Roles::Client))
						->pushCriteria(new WhereCurrentClient($therapist_supervisor->id))
						->pushCriteria(new WithRelation('roles'))
						->all();  
					foreach($clients as $client){ 
					
					foreach($client->therapists as $therapist){
						$supervisors = $therapist->supervisors->first()->id ?? null; 
					}
					if (in_array(\Auth::user()->id,$client->therapists->pluck('id')->toArray()) || $supervisors == \Auth::user()->id) { 
						$clientnames[$client->id] = $this->userService
								->find($client->id);
						 
						$client_names[$client->id]	 =	$clientnames[$client->id];			
						$notes[$client->id] = $this->noteService
							->pushCriteria(new WhereClient($client->id))
							->pushCriteria(new WhereParent())
							->pushCriteria(new WithTherapist())
							->pushCriteria(new WhereEqual('is_draft', 0))
							->pushCriteria(new OrderBy('updated_at', 'desc'))
							->paginate(3);
						$communications[$client->id] = $this->communicationLogService
							->pushCriteria(new WhereEqual('clinic_id', request()->attributes->get('clinic')->id))
							->pushCriteria(new WhereEqual('user_id', $client->id))
							->pushCriteria(new OrderBy('updated_at', 'desc'))
							->paginate(1);
						
						}
					}
			}	
		} 
		if(\Auth::user()->isClient()){
			$client = $this->userService->find(\Auth::user()->id);
			$clinic_id = request()->attributes->get('clinic')->id;
			$score = array();
			$responses = $this->response
				->getByCriteria(new WithRelation('questionnaire'))
				->getByCriteria(new OrderBy('updated_at', 'desc'))
				->getByCriteria(new WhereAssigned(\Auth::user()->id))
				->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
				->all();
			foreach($responses as $response) {
				$response_details = $this->response
					->getByCriteria(new WithQuestionnaire())
					->findBy('uuid', $response->uuid);
				$score[$response->uuid] = $this->response->getScore($response_details);
			}
			
			$user_therapists = $this->userService
				->getByCriteria(new WithTherapistsAndSupervisors(\Auth::user()->id))
				->find(\Auth::user()->id); 
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
				->pushCriteria(new WhereClient($client->id))
				->pushCriteria(new WhereParent())
				->pushCriteria(new WithTherapist())
				->pushCriteria(new WhereEqual('is_draft', 0))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->all();
		}
        if (auth()->user()->isAdmin()) {
            return redirect('admin/dashboard');
        }
		if(\Auth::user()->isTherapist()) {
			return view('dashboard')->with([
				'communications' => $communications,
				'client_names' => $client_names,
				'notes' => $notes,
			]);
		}
		if(\Auth::user()->isClient()){
			return view('dashboard')->with([
				'user' => $client,
				'scores' => $score,
				'communication' => $communication,
				'notes' => $notes,
				'responses' => $responses,
				'therapists' => rtrim($therapists,','),
			]);
		}
    }
	public function checkconsent()
	{
		if (\Auth::user()->first_time_login == 0) {
			\Auth::user()->first_time_login = 1; 
			\Auth::user()->save();
			Notification::send(\Auth::user(), new ConsentEmail());
		}
	}
}