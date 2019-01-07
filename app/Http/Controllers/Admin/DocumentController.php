<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Impl\IDocumentService;
use App\Services\Impl\IUserService;
use App\Services\Impl\IAttachmentService;

/**
 * Manages administrative actions against Document.
 */
class DocumentController extends Controller
{
	/**
     * The attachment service implementation.
     *
     * @var IAttachmentService
     */
    protected $attachmentService;
	
	/**
     * The document service implementation.
     *
     * @var IDocumentService
     */
    protected $document;
	
	/**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;
	
	/**
     * Creates an instance of `DocumentController`.
     *
     * @param IDocumentService $document
     */
    public function __construct(IDocumentService $document,IUserService $userService,IAttachmentService $attachmentService)
    {
        $this->documentService = $document;
        $this->userService = $userService;
		$this->attachmentService = $attachmentService;
    }
	
    /**
     * Display a listing of the resource.
     *
     * @return document
     */
    public function index()
    {
		$documents = $this->documentService->paginate();

        return view('admin.documents.index')->with([
                'documents' => $documents,
            ]);
    }

    /**
     * Show the form for creating a Document.
     *
     * @return Response
     */
    public function create()
    {
        $client = $this->userService->find(request()->user()->id);

        return view('admin.documents.create')->with([
             'client' => $client,
        ]);
    }
	
	/**
     * Saves an Document to the database.
     *
     * @param Request $request
     * @param string  $client
     *
     * @return Response
     */
	public function store(Request $request)
    {
       
        $client = $this->userService->find(request()->user()->id);
		foreach ($request->file('file') as $files) {
			$file = $files;
			
			$path = $file->store('document'); 
			$attachment_id = $this->attachmentService->create([
				'clinic_id' => $request->attributes->get('clinic')->id,
				'file_location' => $path,
				'file_name' => $file->getClientOriginalName(),
				'file_size' => $file->getClientSize(),
				'mime_type' => $file->getClientMimeType(),
				'therapist_id' => $request->user()->id,
				'user_id' => $client->id,
			]);

			$this->documentService->create([
				'name' => $request->name,
				'file_location' => $path,
				'file_name' => $file->getClientOriginalName(),
				'file_size' => $file->getClientSize(),
				'mime_type' => $file->getClientMimeType(),
				'user_id' => $client->id,
				//'digital_signature' =>,
				'description' => $request->description,
				//'uuid' =>,
				//'date' =>,
				//'document_type' => 4,
				'clinic_id' => $request->attributes->get('clinic')->id,
				'document_type_id' => $attachment_id->uuid
			]);
		}
        return redirect()
            ->to("admin/documents/create")
            ->with([
                'message' => __('clients.attachments.create.created-attachment'),
            ]);
    }
}
