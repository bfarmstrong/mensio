<?php

namespace App\Http\Controllers;
use Notification;
use App\Enums\Roles;
use App\Notifications\ConsentEmail;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IUserService;
use App\Services\Impl\INoteService;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\General\WithRelation;
use App\Services\Criteria\Note\WhereClient;
use App\Services\Criteria\Note\WhereParent;
use App\Services\Criteria\Note\WithTherapist;

class PagesController extends Controller
{
	/**
     * The note service implementation.
     *
     * @var INoteService
     */
    protected $noteService;
	
	 /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;
	
	/**
     * The communication log service implementation.
     *
     * @var ICommunicationLogService
     */
    protected $communicationLogService;
	/**
     * Creates an instance of `NoteController`.
     *
     * @param ICommunicationLogService $communicationLogService
     * @param IUserService             $userService
     */
    public function __construct(
        ICommunicationLogService $communicationLogService,
        IUserService $userService,
		INoteService $noteService
    ) {
        $this->communicationLogService = $communicationLogService;
        $this->userService = $userService;
		$this->noteService = $noteService;
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
		$clients = $this->userService
            ->pushCriteria(new WhereRelationEqual('roles', 'level', Roles::Client))
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRelation('roles'))
			->all();
		foreach($clients as $client) {	
			$notes[$client->id] = $this->noteService
				->pushCriteria(new WhereClient($client->id))
				->pushCriteria(new WhereParent())
				->pushCriteria(new WithTherapist())
				->pushCriteria(new WhereEqual('is_draft', 0))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->paginate(1);
			$communications[$client->id] = $this->communicationLogService
				->pushCriteria(new WhereEqual('clinic_id', request()->attributes->get('clinic')->id))
				->pushCriteria(new WhereEqual('user_id', $client->id))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->paginate(1);
			$client_names[$client->id] = $this->userService->find($client->id);
		}	
        if (auth()->user()->isAdmin()) {
            return redirect('admin/dashboard');
        }

        return view('dashboard')->with([
            'communications' => $communications,
            'client_names' => $client_names,
            'notes' => $notes,
        ]);
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
