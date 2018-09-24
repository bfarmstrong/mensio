<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Criteria\User\WhereClient;
use App\Services\Criteria\User\WhereCurrentClient;
use App\Services\Impl\IUserService;
use Illuminate\Http\Response;

/**
 * Manages a list of clients.
 */
class ClientController extends Controller
{
    /**
     * The user service implementation.
     *
     * @var IUserService
     */
    protected $user;

    /**
     * Creates an instance of `ClientController`.
     *
     * @param IUserService $user
     */
    public function __construct(IUserService $user)
    {
        $this->user = $user;
    }

    /**
     * Displays the page to add clients to a user.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewClients', User::class);
        $clients = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->paginate();

        return view('clients.index')->with([
            'clients' => $clients,
        ]);
    }

    /**
     * Displays the page for a single client's information.  The client must be
     * a client of the current user.
     *
     * @param string $user
     *
     * @return Response
     */
    public function show(string $user)
    {
        $this->authorize('viewClients', User::class);
        $client = $this->user
            ->pushCriteria(new WhereClient())
            ->pushCriteria(new WhereCurrentClient(\Auth::user()->id))
            ->find($user);

        return view('clients.show')->with([
            'user' => $client,
        ]);
    }
}
