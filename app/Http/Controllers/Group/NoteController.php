<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupNote\AddAdditionalNoteRequest;
use App\Http\Requests\GroupNote\CreateGroupNoteRequest;
use App\Http\Requests\GroupNote\UpdateNoteRequest;
use App\Services\Criteria\General\OrderBy;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IAttachmentService;
use App\Services\Impl\IClinicService;
use App\Services\Impl\ICommunicationLogService;
use App\Services\Impl\IGroupService;
use App\Services\Impl\INoteService;
use App\Services\Impl\IReceiptService;
use App\Services\Impl\IUserService;
use DB;
use Illuminate\Http\Response;

/**
 * Handles actions related to notes against a group.
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
    protected $communicationLogController;

    /**
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $groupService;

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
     * Creates an instance of `GroupNotController`.
     *
     * @param IAttachmentService       $attachmentService
     * @param IClinicService           $clinicService
     * @param ICommunicationLogService $communicationLogService
     * @param IGroupService            $groupService
     * @param INoteService             $noteService
     * @param IReceiptService          $receiptService
     * @param IUserService             $userService
     */
    public function __construct(
        IAttachmentService $attachmentService,
        IClinicService $clinicService,
        ICommunicationLogService $communicationLogService,
        IGroupService $groupService,
        INoteService $noteService,
        IReceiptService $receiptService,
        IUserService $userService
    ) {
        $this->attachmentService = $attachmentService;
        $this->clinicService = $clinicService;
        $this->communicationLogService = $communicationLogService;
        $this->groupService = $groupService;
        $this->noteService = $noteService;
        $this->receiptService = $receiptService;
        $this->userService = $userService;
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
        $clinic = request()->attributes->get('clinic');

        $finals = $this->noteService
            ->pushCriteria(new WhereEqual('clinic_id', $clinic->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->pushCriteria(new WhereEqual('is_draft', 0))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'finals_page');

        $drafts = $this->noteService
            ->pushCriteria(new WhereEqual('clinic_id', $clinic->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->pushCriteria(new WhereEqual('is_draft', 1))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'drafts_page');

        $attachments = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $clinic->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'attachments_page');

        $communication = $this->communicationLogService
            ->pushCriteria(new WhereEqual('clinic_id', $clinic->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'communication_page');

        $receipts = $this->receiptService
            ->pushCriteria(new WhereEqual('clinic_id', $clinic->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->pushCriteria(new OrderBy('updated_at', 'desc'))
            ->paginate(15, 'receipts_page');

        return view('admin.groups.notes.index')->with([
            'attachments' => $attachments,
            'communication' => $communication,
            'drafts' => $drafts,
            'finals' => $finals,
            'group' => $group,
            'receipts' => $receipts,
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
     * @param string                 $uuid
     *
     * @return Response
     */
    public function store(CreateGroupNoteRequest $request, string $uuid)
    {
        $group = $this->groupService->findBy('uuid', $uuid);
        $clinic = $request->attributes->get('clinic');

        DB::transaction(function () use ($clinic, $group, $request) {
            $note = $this->noteService->create(
                array_merge(
                    $request->all(),
                    [
                        'clinic_id' => $clinic->id,
                        'group_id' => $group->id,
                        'therapist_id' => $request->user()->id,
                    ]
                )
            );

            if (! $note->is_draft) {
                $this->userService->compareSignature(
                    $request->user(),
                    $request->get('signature')
                );

                $clients = $this->groupService->findClients($group);
                foreach ($clients as $client) {
                    $this->noteService->create(
                        array_merge(
                            $request->all(),
                            [
                                'client_id' => $client->id,
                                'clinic_id' => $clinic->id,
                                'group_id' => $group->id,
                                'therapist_id' => $request->user()->id,
                            ]
                        )
                    );
                }

                // The draft note is deleted after saving the final copy
                $this->noteService->delete($note);
            }
        });

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
        $note = $this->noteService->findBy('uuid', $note);

        return view('admin.groups.notes.show')->with([
            'note' => $note,
            'group' => $group,
        ]);
    }

    /**
     * Updates a note attached to a group.
     *
     * @param UpdateNoteRequest $request
     * @param string            $group
     * @param string            $note
     *
     * @return Response
     */
    public function update(UpdateNoteRequest $request, string $group, string $note)
    {
        $group = $this->groupService->findBy('uuid', $group);
        $note = $this->noteService->findBy('uuid', $note);

        DB::transaction(function () use ($group, $note, $request) {
            $this->noteService->update(
                $note,
                $request->except(['files', 'signature'])
            );

            if (! $request->get('is_draft')) {
                $this->userService->compareSignature(
                    $request->user(),
                    $request->get('signature')
                );

                $clients = $this->groupService->findClients($group);
                foreach ($clients as $client) {
                    $this->noteService->create(
                        array_merge(
                            $request->all(),
                            [
                                'client_id' => $client->id,
                                'clinic_id' => $note->clinic_id,
                                'group_id' => $group->id,
                                'therapist_id' => $request->user()->id,
                            ]
                        )
                    );
                }

                // The draft note is deleted after saving the final copy
                $this->noteService->delete($note);
            }
        });

        return redirect()->to("groups/$group->uuid/notes")->with([
            'message' => __('groups.notes.index.note-updated'),
        ]);
    }

    /**
     * Adds additional information to an existing note.
     *
     * @param AddAdditionalNoteRequest $request
     * @param string                   $group
     * @param string                   $note
     *
     * @return Response
     */
    public function addAddition(
        AddAdditionalNoteRequest $request,
        string $group,
        string $note
    ) {
        $group = $this->groupService->findBy('uuid', $group);
        $note = $this->noteService->findBy('uuid', $note);

        $this->userService->compareSignature(
            $request->user(),
            $request->get('signature')
        );
        $this->noteService->addAddition($note, $request->get('addition'));

        return redirect()->back()->with([
            'message' => __('groups.notes.show.additional-added'),
        ]);
    }
}
