<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Client\CreateDocumentRequest;
use App\Services\Impl\IDocumentService;
use App\Services\Impl\IUserService;
use App\Services\Impl\IAttachmentService;
use App\DataTables\DocumentsDataTable;
use App\DataTables\DocumentsDataTablesEditor;

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
	public function index(DocumentsDataTable $dataTable,string $user)
    {	
		$client = $this->userService->find($user);
        return $dataTable->render('clients.documents.index')->with([
             'client' => $client,
        ]);
    }
    /**
     * Show the form for creating a Document.
     *
     * @return Response
     */
    public function create(string $user)
    { 
        $client = $this->userService->find($user);

        return view('clients.documents.create')->with([
             'client' => $client,
        ]);
    }
	
	/**
     * Saves an Document to the database.
     *
     * @param Request $request
     * @param string  $user
     *
     * @return Response
     */
	public function postcreate(CreateDocumentRequest $request,string $user)
    { 
        if ($request->get('is_signed') == 1) {	
			$this->userService->compareSignature(
				$request->user(),
				$request->get('signature')
			);
		}
			$file = $request->file('file');
			$path = $file->store('document'); 
			if($request->document_type == 1){
				$attachment_id = $this->attachmentService->create([
					'clinic_id' => $request->attributes->get('clinic')->id,
					'file_location' => $path,
					'file_name' => $file->getClientOriginalName(),
					'file_size' => $file->getClientSize(),
					'mime_type' => $file->getClientMimeType(),
					'therapist_id' => request()->user()->id,
					'user_id' => $user,
				]);

				$this->documentService->create([
					'name' => $request->name,
					'file_location' => $path,
					'file_name' => $file->getClientOriginalName(),
					'file_size' => $file->getClientSize(),
					'mime_type' => $file->getClientMimeType(),
					'user_id' => request()->user()->id,
					'description' => $request->description,
					'clinic_id' => $request->attributes->get('clinic')->id,
					'document_type' => $request->document_type,
					'document_type_id' => $attachment_id->uuid,
					'client_id' => $user,
					'is_signed' =>$request->get('is_signed')
				]);
			} else {
				$this->documentService->create([
					'name' => $request->name,
					'file_location' => $path,
					'file_name' => $file->getClientOriginalName(),
					'file_size' => $file->getClientSize(),
					'mime_type' => $file->getClientMimeType(),
					'user_id' => request()->user()->id,
					'description' => $request->description,
					'clinic_id' => $request->attributes->get('clinic')->id,
					'document_type' => $request->document_type,
					'client_id' => $user,
					'is_signed' =>$request->get('is_signed')
				]);
			}
        return redirect()
            ->to("clients/documents/create/".$user)
            ->with([
                'message' => __('clients.attachments.create.created-attachment'),
            ]);
    }
	
	public function store(DocumentsDataTablesEditor $editor,string $user)
    { 	
        return $editor->process(request());
    }
}
