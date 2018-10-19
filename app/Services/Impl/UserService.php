<?php

namespace App\Services\Impl;

use App\Exceptions\DigitalSignatureInvalidException;
use App\Notifications\NewAccountEmail;
use App\Services\BaseService;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Notification;
use Session;

/**
 * Implementation of the user service.
 */
class UserService extends BaseService implements IUserService
{
    /**
     * Returns the model that the service will use.
     *
     * @return string
     */
    public function model()
    {
        return \App\Models\User::class;
    }

    /**
     * Adds a patient to a user.
     *
     * @param mixed $patient
     * @param mixed $user
     *
     * @return void
     */
    public function addPatient($patient, $user)
    {
        $user = $this->find($user);
        $user->patients()->attach($patient);
    }

    /**
     * Removes a patient from a user.
     *
     * @param mixed $patient
     * @param mixed $user
     *
     * @return void
     */
    public function removePatient($patient, $user)
    {
        $user = $this->find($user);
        $user->patients()->detach($patient);
    }

    /**
     * Adds a therapist to a user.
     *
     * @param mixed $therapist
     * @param mixed $user
     *
     * @return void
     */
    public function addTherapist($therapist, $user)
    {
        $user = $this->find($user);
        $user->therapists()->attach($therapist);
    }

    /**
     * Removes a therapist from a user.
     *
     * @param mixed $therapist
     * @param mixed $user
     *
     * @return void
     */
    public function removeTherapist($therapist, $user)
    {
        $user = $this->find($user);
        $user->therapists()->detach($therapist);
    }

    /**
     * Compares a digital signature to a therapist to ensure that the
     * signature is valid.
     *
     * @param mixed $therapist
     * @param array $signature
     *
     * @return bool
     */
    public function compareSignature($therapist, array $signature)
    {
        $therapist = $this->find($therapist);
        if (
            ! isset($signature['name']) ||
            ! isset($signature['license']) ||
            $therapist->name !== $signature['name'] ||
            $therapist->license !== $signature['license']
        ) {
            throw new DigitalSignatureInvalidException();
        }

        return true;
    }

    /**
     * Verifies that a therapist is in fact a therapist of the provided
     * client.
     *
     * @param mixed  $therapist
     * @param string $client
     *
     * @return bool
     */
    public function verifyTherapist($therapist, string $client)
    {
        $therapist = $this->find($therapist);

        return $therapist->patients()->where('patient_id', $client)->exists();
    }

    /**
     * Creates a new user and sends them the welcome email.
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function invite(array $attributes)
    {
        $password = substr(md5(rand(1111, 9999)), 0, 10);

        $user = $this->create(array_merge($attributes, [
            'is_active' => true,
            'password' => bcrypt($password),
        ]));

        Notification::send($user, new NewAccountEmail($password));

        return $user;
    }

    /**
     * Switches back to the original user.
     *
     * @return void
     */
    public function switchBack()
    {
        $original = Session::pull('original_user');
        $user = $this->find($original);
        Auth::login($user);
    }

    /**
     * Switches to the specified user.
     *
     * @param string $id
     *
     * @return void
     */
    public function switchToUser(string $id)
    {
        $user = $this->find($id);
        Session::put('original_user', Auth::id());
        Auth::login($user);
    }

    /**
     * Updates the supervisor for a client, returns if the operation was
     * successful.
     *
     * @param mixed  $client
     * @param mixed  $therapist
     * @param string $supervisor
     *
     * @return bool
     */
    public function updateSupervisor($client, $therapist, $supervisor)
    {
        $client = $this->find($client);
        $therapist = $this->find($therapist);

        if (is_null($supervisor)) {
            $therapist->supervisors()->detach();
        } else {
            $therapist->supervisors()->sync([
                $supervisor => [
                    'client_id' => $client->id,
                ],
            ]);
        }

        return true;
    }

    /**
     * Enables searching for a user by their name.  The name field is encrypted
     * and so we must use a blind index.
     *
     * @param string $query
     *
     * @return LengthAwarePaginator
     */
    public function search(string $query)
    {
        $model = app($this->model());
        $searchIndex = $model->getSearchIndex($query);

        $this->applyCriteria();
        $this->model->where($model->getBlindIndexColumn(), $searchIndex);
        $results = $this->model->paginate();
        $this->resetCriteria();

        return $results;
    }
}