<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSignatureRequest;
use App\Services\Impl\IUserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

/**
 * Manages the user saved signature.
 */
class SignatureController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $userService;

    /**
     * Creates an instance of `SignatureController`.
     *
     * @param IUserService $userService
     */
    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Returns the image file for the written signature if it exists.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function download(Request $request)
    {
        if (is_null($request->user()->written_signature)) {
            abort(404);
        }

        return Storage::disk(config('filesystems.cloud'))
            ->download($request->user()->written_signature);
    }

    /**
     * Displays the form for a user to update their signature on record.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Request $request)
    {
        return view('user.signature')->with([
            'user' => $request->user(),
        ]);
    }

    /**
     * Updates the user's signature in the database.
     *
     * @param UpdateSignatureRequest $request
     *
     * @return Response
     */
    public function update(UpdateSignatureRequest $request)
    {
        $this->userService->updateSignature(
            $request->user(),
            $request->file('signature_file') ??
                $request->get('signature_base64')
        );

        return redirect('user/settings')->with([
            'message' => __('user.signature.signature-updated'),
        ]);
    }
}
