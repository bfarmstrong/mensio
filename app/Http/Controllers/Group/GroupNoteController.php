<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupNote\AddAdditionalNoteRequest;
use App\Http\Requests\GroupNote\CreateGroupNoteRequest;
use App\Http\Requests\GroupNote\UpdateNoteRequest;
use App\Services\Impl\IGroupNoteService;
use App\Services\Impl\INoteService;
use App\Services\Impl\IGroupService;
use App\Models\Group;
use App\Models\GroupNote;
use App\Models\User;
use App\Models\Note;
use Illuminate\Http\Response;
use App\Services\Impl\IUserService;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Criteria\User\WithRole;
use App\Services\Impl\IClinicService;
use Config;
/**
 * Handles actions related to notes against a group.
 */
class GroupNoteController extends Controller
{
    /**
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $groupService;

    /**
     * The note service implementation.
     *
     * @var IGroupNoteService
     */
    protected $groupnoteService;

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

    protected $user;

	/**
     * The clinic service implementation.
     *
     * @var IClinicService
     */
	protected $clinicservice;

    /**
     * Creates an instance of `IGroupNoteService`.
     *
     * @param IGroupService $groupService
     * @param IGroupNoteService $groupnoteService
     */
    public function __construct(
        IGroupService $groupService,
        IGroupNoteService $groupnoteService,
		INoteService $noteService,
		IUserService $user,
		IClinicService $clinicservice
    ) {
        $this->groupService = $groupService;
        $this->groupnoteService = $groupnoteService;
		$this->noteService = $noteService;
		$this->user = $user;
		$this->clinicservice = $clinicservice;
    }

	/**
     * Displays the page with the list of notes for a group.
     *
     * @param string $uuid
     *
     * @return Response
    */
    public function index(string $uuid)
    {
        $group = $this->groupService->findBy('uuid', $uuid);
		$clinic_id = request()->attributes->get('clinic')->id;
        if(request()->user()->isAdmin()) {

            $notes = $this->groupnoteService
                ->getByCriteria(new WhereEqual('group_id', $group->id))
                ->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
                ->paginate();
		} else {
            $notes = $this->groupnoteService
                ->getByCriteria(new WhereEqual('group_id', $group->id))
                ->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
                ->getByCriteria(new WhereEqual('created_by', request()->user()->id))
                ->paginate();
        }

        return view('admin.groups.notes.index')->with([
            'notes' => $notes,
            'group' => $group,
        ]);
    }

    /**
     * Displays the page to create a new note.
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function create(string $uuid)
    {
        $group = $this->groupService->findBy('uuid', $uuid);

        return view('admin.groups.notes.create')->with([
            'group' => $group,
        ]);
    }
    /**
     * Creates a new note attached to a group.
     *
     * @param CreateGroupNoteRequest $request
     *
     * @return Response
     */
    public function store(CreateGroupNoteRequest $request)
    {
        $group = Group::find($request->group_id);
		$clinic_id = null;
		$clinic_id = request()->attributes->get('clinic')->id;
		$id =	GroupNote::create(array_merge($request->all(), [
				'group_id' => $group->id,
				'clinic_id'=>$clinic_id
			]));
		if ($request->is_draft == 0 ) {
			$clients = $this->user
				->pushCriteria(new WhereClient())
				->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
				->pushCriteria(new WithRole())
				->all();

			foreach($clients as $client){
				$this->noteService->create(array_merge($request->all(), [
					'client_id' => $client->id,
					'therapist_id'=>\Auth::user()->id,
					'group_note_id'=>$id->id,
					'clinic_id'=>$clinic_id
				]));
			}
		}



        return redirect()->to("groups/$group->uuid/notes")->with([
            'message' => __('groups.notes.index.note-created'),
        ]);
    }
    /**
     * Displays the page with the details for a specific note.
     *
     * @param string $group
     * @param string $note
     *
     * @return Response
     */
    public function show(string $group, string $note)
    {
        $group = $this->groupService->findBy('uuid', $group);
        $note = $this->groupnoteService->findBy('uuid', $note);

        return view('admin.groups.notes.show')->with([
            'note' => $note,
            'group' => $group,
        ]);
    }

    /**
     * Updates a note attached to a group.
     *
     * @param UpdateNoteRequest $request
     *
     * @return Response
     */
    public function update(UpdateNoteRequest $request)
    {
        $group = Group::find($request->group_id);
		$note = GroupNote::find($request->note_id);
		$note_check= Note::where('group_note_id',$request->note_id)->count();
		if ($request->is_draft == 0 && $note_check == 0) {
			$clients = $this->user
				->pushCriteria(new WhereClient())
				->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
				->pushCriteria(new WithRole())
				->all();

			foreach($clients as $client){
				$this->noteService->create(array_merge($request->all(), [
					'client_id' => $client->id,
					'therapist_id'=>\Auth::user()->id,
					'group_note_id'=>$request->note_id
				]));
			}
		}
		GroupNote::whereId($request->note_id)->update($request->except(['_token', '_method','files','signature']));

        return redirect()->to("groups/$group->uuid/notes")->with([
            'message' => __('groups.notes.index.note-updated'),
        ]);
    }

	/**
     * Adds additional information to an existing note.
     *
     * @param AddAdditionalNoteRequest $request
     *
     * @return Response
     */
    public function addAddition(AddAdditionalNoteRequest $request)
    {
        $group = Group::find($request->group_id);
		$note = GroupNote::find($request->note_id);

        $this->groupnoteService->addAddition($note, $request->get('addition'));

        return redirect()->back()->with([
            'message' => __('groups.notes.show.additional-added'),
        ]);
    }
}
