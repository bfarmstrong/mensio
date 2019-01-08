<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateAttachmentRequest;
use App\Models\Attachment;
use App\Services\Criteria\General\WhereEqual;
use App\Services\Impl\IAttachmentService;
use App\Services\Impl\IUserService;
use Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

/**
 * Manages attachments on a client resource.
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
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `AttachmentController`.
     *
     * @param IAttachmentService $attachmentService
     * @param IUserService       $userService
     */
    public function __construct(
        IAttachmentService $attachmentService,
        IUserService $userService
    ) {
        $this->attachmentService = $attachmentService;
        $this->userService = $userService;
    }

    /**
     * Displays the form for a user to add an attachment to a client.
     *
     * @param string $id
     *
     * @return Response
     */
    public function create(string $id)
    {
        $this->authorize('create', Attachment::class);
        $client = $this->userService->find($id);

        return view('clients.attachments.create')->with([
            'client' => $client,
        ]);
    }

    /**
     * Sends the raw contents of the attachment file in the response.
     *
     * @param Request $request
     * @param string  $client
     * @param string  $attachment
     *
     * @return Response
     */
    public function download(Request $request, string $client, string $attachment)
    {
        $client = $this->userService->find($client);
        $attachment = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('user_id', $client->id))
            ->findBy('uuid', $attachment);
        $this->authorize('view', $attachment);

        return Storage::disk(config('filesystems.cloud'))->download($attachment->file_location);
    }

    /**
     * Returns a page to view an attachment.
     *
     * @param Request $request
     * @param string  $client
     * @param string  $attachment
     *
     * @return Response
     */
    public function show(Request $request, string $client, string $attachment)
    {
        $client = $this->userService->find($client);
        $attachment = $this->attachmentService
            ->pushCriteria(new WhereEqual('clinic_id', $request->attributes->get('clinic')->id))
            ->pushCriteria(new WhereEqual('user_id', $client->id))
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

        return view('clients.attachments.show')->with([
            'attachment' => $attachment,
            'client' => $client,
        ]);
    }

    /**
     * Saves an attachment to the database.
     *
     * @param CreateAttachmentRequest $request
     * @param string                  $client
     *
     * @return Response
     */
    public function store(CreateAttachmentRequest $request, string $id)
    {
        $this->authorize('create', Attachment::class);
        $client = $this->userService->find($id);
        $file = $request->file('file');

        $path = $file->store('attachments');
        $this->attachmentService->create([
            'clinic_id' => $request->attributes->get('clinic')->id,
            'file_location' => $path,
            'file_name' => $file->getClientOriginalName(),
            'file_size' => $file->getClientSize(),
            'mime_type' => $file->getClientMimeType(),
            'therapist_id' => $request->user()->id,
            'user_id' => $client->id,
        ]);

        return redirect()
            ->to("clients/$client->id/attachments/create")
            ->with([
                'message' => __('clients.attachments.create.created-attachment'),
            ]);
    }
}
