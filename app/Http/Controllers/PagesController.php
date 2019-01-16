<?php

namespace App\Http\Controllers;
use Notification;
use App\Enums\Roles;
use App\Notifications\ConsentEmail;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IUserService;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Criteria\General\WhereRelationEqual;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\General\WithRelation;

class PagesController extends Controller
{
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
        IUserService $userService
    ) {
        $this->communicationLogService = $communicationLogService;
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
		$clients = $this->userService
            ->pushCriteria(new WhereRelationEqual('roles', 'level', Roles::Client))
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->pushCriteria(new WithRelation('roles'))
			->all();
		foreach($clients as $client) {	
			$communications[$client->id] = $this->communicationLogService
				//->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
				->pushCriteria(new WhereEqual('user_id', $client->id))
				->pushCriteria(new OrderBy('updated_at', 'desc'))
				->paginate(1, 'communication_page');
			$client_names[$client->id] = $this->userService->find($client->id);
		}	
        if (auth()->user()->isAdmin()) {
            return redirect('admin/dashboard');
        }

        return view('dashboard')->with([
            'communications' => $communications,
            'client_names' => $client_names,
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
