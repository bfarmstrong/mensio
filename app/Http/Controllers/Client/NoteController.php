<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddAdditionalNoteRequest;
use App\Http\Requests\Client\CreateNoteRequest;
use App\Http\Requests\Client\UpdateNoteRequest;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\Note\WhereClient;
use App\Services\Criteria\Note\WhereParent;
use App\Services\Criteria\Note\WithChildren;
use App\Services\Criteria\Note\WithTherapist;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\INoteService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Response;
use App\Services\Impl\IClinicService;
use Config;
/**
 * Handles actions related to notes against a client.
 */
class NoteController extends Controller
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
     * The clinic service implementation.
     *
     * @var IClinicService
     */
	protected $clinicservice;

    /**
     * Creates an instance of `NoteController`.
     *
     * @param INoteService $noteService
     * @param IUserService $userService
     */
    public function __construct(
        INoteService $noteService,
        IUserService $userService,
		IClinicService $clinicservice
    ) {
        $this->noteService = $noteService;
        $this->userService = $userService;
		$this->clinicservice = $clinicservice;
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
        $client = $this->userService->find($request->user_id);
        $this->authorize('addNote', $client);

        $note = $this->noteService->findBy('uuid', $request->note_id);
        $this->userService->compareSignature(
            auth()->user(),
            $request->get('signature')
        );
        $this->noteService->addAddition($note, $request->get('addition'));

        return redirect()->back()->with([
            'message' => __('clients.notes.show.additional-added'),
        ]);
    }

    /**
     * Displays the page to create a new note.
     *
     * @param string $client
     *
     * @return Response
     */
    public function create(string $client)
    {
        $client = $this->userService->find($client);
        $this->authorize('addNote', $client);

        return view('clients.notes.create')->with([
            'user' => $client,
        ]);
    }

    /**
     * Displays the page with the list of notes for a client.
     *
     * @param string $client
     *
     * @return Response
     */
    public function index(string $client)
    {
        $client = $this->userService->find($client);
        $this->authorize('viewNotes', $client);
        $clinic_id = request()->attributes->get('clinic')->id;
        $notes = $this->noteService
            ->pushCriteria(new WhereClient($client->id))
            ->pushCriteria(new WhereParent())
            ->pushCriteria(new WithTherapist())
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
			->getByCriteria(new WhereEqual('clinic_id', $clinic_id))
            ->paginate();

        return view('clients.notes.index')->with([
            'notes' => $notes,
            'user' => $client,
        ]);
    }

    /**
     * Displays the page with the details for a specific note.
     *
     * @param string $client
     * @param string $note
     *
     * @return Response
     */
    public function show(string $client, string $note)
    {
        $client = $this->userService->find($client);
        $this->authorize('viewNotes', $client);

        $note = $this->noteService
            ->pushCriteria(new WhereClient($client->id))
            ->pushCriteria(new WhereParent())
            ->pushCriteria(new WithChildren())
            ->pushCriteria(new WithTherapist())
            ->findBy('uuid', $note);

        return view('clients.notes.show')->with([
            'note' => $note,
            'user' => $client,
        ]);
    }

    /**
     * Creates a new note attached to a client.
     *
     * @param CreateNoteRequest $request
     *
     * @return Response
     */
    public function store(CreateNoteRequest $request)
    {
        $client = $this->userService->find($request->user_id);
        $this->authorize('addNote', $client);
        $clinic_id = request()->attributes->get('clinic')->id ?? null;
        $this->noteService->create(array_merge($request->all(), [
            'client_id' => $client->id,
			'clinic_id' => $clinic_id,
        ]));

        return redirect()->to("clients/$client->id/notes")->with([
            'message' => __('clients.notes.index.note-created'),
        ]);
    }

    /**
     * Updates a note attached to a client.
     *
     * @param UpdateNoteRequest $request
     *
     * @return Response
     */
    public function update(UpdateNoteRequest $request)
    {
        $client = $this->userService->find($request->user_id);
        $this->authorize('updateNote', $client);

        $note = $this->noteService
            ->pushCriteria(new WhereClient($client->id))
            ->pushCriteria(new WhereParent())
            ->findBy('uuid', $request->note_id);

        $this->noteService->update($note, $request->all());

        return redirect()->to("clients/$client->id/notes")->with([
            'message' => __('clients.notes.index.note-updated'),
        ]);
    }
}
