<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateAttachmentRequest;
use App\Models\Attachment;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IAttachmentService;
use App\Services\Impl\IGroupService;
use App\Services\Impl\IUserService;
use Config;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

/**
 * Manages attachments on a group resource.
 */
class AttachmentController extends Controller
{
    /**
     * The attachment service implementation.
     *
     * @var IAttachmentService
     */
    protected $attachmentService;

    /**
     * The group service implementation.
     *
     * @var IGroupService
     */
    protected $groupService;

    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `AttachmentController`.
     *
     * @param IAttachmentService $attachmentService
     * @param IGroupService      $groupService
     * @param IUserService       $userService
     */
    public function __construct(
        IAttachmentService $attachmentService,
        IGroupService $groupService,
        IUserService $userService
    ) {
        $this->attachmentService = $attachmentService;
        $this->groupService = $groupService;
        $this->userService = $userService;
    }

    /**
     * Displays the form for a user to add an attachment to a group.
     *
     * @param string $id
     *
     * @return Response
     */
    public function create(string $id)
    {
        $this->authorize('create', Attachment::class);
        $group = $this->groupService->findBy('uuid', $id);

        return view('admin.groups.attachments.create')->with([
            'group' => $group,
        ]);
    }

    /**
     * Sends the raw contents of the attachment file in the response.
     *
     * @param Request $request
     * @param string  $group
     * @param string  $attachment
     *
     * @return Response
     */
    public function download(Request $request, string $group, string $attachment)
    {
        $group = $this->groupService->findBy('uuid', $group);
        $attachment = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->findBy('uuid', $attachment);
        $this->authorize('view', $attachment);

        return Storage::disk(config('filesystems.cloud'))->download($attachment->file_location);
    }

    /**
     * Returns a page to view an attachment.
     *
     * @param Request $request
     * @param string  $group
     * @param string  $attachment
     *
     * @return Response
     */
    public function show(Request $request, string $group, string $attachment)
    {
        $group = $this->groupService->findBy('uuid', $group);
        $attachment = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('group_id', $group->id))
            ->findBy('uuid', $attachment);
        $this->authorize('view', $attachment);

        // Only images and text files are viewable on the website.  All other
        // types of files are handled by the browser.
        if (
            ! starts_with($attachment->mime_type, 'image/') &&
            'text/plain' !== $attachment->mime_type
        ) {
            $file = Storage::disk(config('filesystems.cloud'))->get($attachment->file_location);

            return response($file)
                ->header('Content-Type', $attachment->mime_type)
                ->header('Content-Disposition', "inline; filename=\"$attachment->file_name\"");
        }

        return view('admin.groups.attachments.show')->with([
            'attachment' => $attachment,
            'group' => $group,
        ]);
    }

    /**
     * Saves an attachment to the database.
     *
     * @param CreateAttachmentRequest $request
     * @param string                  $group
     *
     * @return Response
     */
    public function store(CreateAttachmentRequest $request, string $group)
    {
        return DB::transaction(function () use ($request, $group) {
            $this->authorize('create', Attachment::class);
            $group = $this->groupService->findBy('uuid', $group);
            $clients = $this->groupService->findClients($group);
            $file = $request->file('file');

            $path = $file->store('attachments', config('filesystems.cloud'));
            foreach ($clients as $client) {
                $this->attachmentService->create([
                    'clinic_id' => $request->attributes->get('clinic')->id,
                    'file_location' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getClientSize(),
                    'group_id' => $group->id,
                    'mime_type' => $file->getClientMimeType(),
                    'therapist_id' => $request->user()->id,
                    'user_id' => $client->id,
                ]);
            }

            return redirect()
                ->to("groups/$group->uuid/attachments/create")
                ->with([
                    'message' => __('clients.attachments.create.created-attachment'),
                ]);
        });
    }
}
