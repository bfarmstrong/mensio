<?php

namespace App\Importer;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;

/**
 * Service class which facilitates access to the legacy API system.
 */
class LegacyApiService implements ILegacyApiService
{
    /**
     * The client to communicate with the legacy API.
     *
     * @var Client
     */
    protected $client;

    /**
     * Creates an instance of `LegacyApiService`.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://mindspaceclinic.tech',
        ]);
    }

    /**
     * Requests all user data from the legacy API.  Returns the collection of
     * data that is retrieved.
     *
     * @return Collection
     */
    public function getUserData()
    {
        $data = $this->client
            ->get('admin/users/json')
            ->getBody()
            ->getContents();

        $data = collect(json_decode($data));
        return $data->map(function ($user) {
            $user->clients = collect($user->clients);

            return $user;
        });
    }
}
