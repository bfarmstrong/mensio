<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\AddAdditionalNoteRequest;
use App\Http\Requests\Client\CreateNoteRequest;
use App\Http\Requests\Client\UpdateNoteRequest;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Criteria\Note\WhereClient;
use App\Services\Criteria\Note\WhereParent;
use App\Services\Criteria\Note\WithChildren;
use App\Services\Criteria\Note\WithTherapist;
use App\Services\Impl\IAttachmentService;
use App\Services\Impl\IClinicService;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\INoteService;
use App\Services\Impl\IReceiptService;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DataTables\CommunicationDataTable;
use App\DataTables\CommunicationDataTablesEditor;
/**
 * Handles actions related to notes against a client.
 */
class NoteController extends Controller
{
    /**
     * The attachment service implementation.
     *
     * @var IAttachmentService
     */
    protected $attachmentService;

    /**
     * The communication log service implementation.
     *
     * @var ICommunicationLogService
     */
    protected $communicationLogService;

    /**
     * The note service implementation.
     *
     * @var INoteService
     */
    protected $noteService;

    /**
     * The receipt service implementation.
     *
     * @var IReceiptService
     */
    protected $receiptService;

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
    protected $clinicService;

    /**
     * Creates an instance of `NoteController`.
     *
     * @param IAttachmentService       $attachmentService
     * @param IClinicService           $clinicService
     * @param ICommunicationLogService $communicationLogService
     * @param INoteService             $noteService
     * @param IReceiptService          $receiptService
     * @param IUserService             $userService
     */
    public function __construct(
        IAttachmentService $attachmentService,
        IClinicService $clinicService,
        ICommunicationLogService $communicationLogService,
        INoteService $noteService,
        IReceiptService $receiptService,
        IUserService $userService
    ) {
        $this->attachmentService = $attachmentService;
        $this->communicationLogService = $communicationLogService;
        $this->noteService = $noteService;
        $this->receiptService = $receiptService;
        $this->userService = $userService;
        $this->clinicService = $clinicService;
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
     * @param Request $request
     * @param string  $client
     *
     * @return Response
     */
    public function index(Request $request, string $client,CommunicationDataTable $dataTable)
    {
        $client = $this->userService->find($client);
        $this->authorize('viewNotes', $client);
        $clinic_id = request()->attributes->get('clinic')->id;
        $finals = $this->noteService
            ->pushCriteria(new WhereClient($client->id))
            ->pushCriteria(new WhereParent())
            ->pushCriteria(new WithTherapist())
            ->pushCriteria(new WhereEqual('is_draft', 0))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'finals_page');

        $drafts = $this->noteService
            ->pushCriteria(new WhereClient($client->id))
            ->pushCriteria(new WhereParent())
            ->pushCriteria(new WithTherapist())
            ->pushCriteria(new WhereEqual('is_draft', 1))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'drafts_page');

        $attachments = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('user_id', $client->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'attachments_page');

        $communication = $this->communicationLogService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('user_id', $client->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'communication_page');
		
        $receipts = $this->receiptService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('user_id', $client->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'receipts_page');
		return $dataTable->render('clients.notes.index',[
            'attachments' => $attachments,
            'communication' => $communication,
            'drafts' => $drafts,
            'finals' => $finals,
            'receipts' => $receipts,
            'user' => $client
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
        if (! $request->get('is_draft')) {
            $this->userService->compareSignature(
                $request->user(),
                $request->get('signature')
            );
        }
        $this->noteService->create(array_merge($request->all(), [
            'client_id' => $client->id,
            'clinic_id' => $clinic_id,
        ]));

        return redirect()->to("clients/$client->id/notes")->with([
            'message' => __('clients.notes.index.note-created'),
        ]);
    }
	public function submitlog(CommunicationDataTablesEditor $editor)
	{
		return $editor->process(request());
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

        if (! $request->get('is_draft')) {
            $this->userService->compareSignature(
                $request->user(),
                $request->get('signature')
            );
        }
        $this->noteService->update($note, $request->all());

        return redirect()->to("clients/$client->id/notes")->with([
            'message' => __('clients.notes.index.note-updated'),
        ]);
    }
}
