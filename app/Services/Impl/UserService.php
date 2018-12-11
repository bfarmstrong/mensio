<?php

namespace App\Services\Impl;

use App\Exceptions\DigitalSignatureInvalidException;
use App\Notifications\NewAccountEmail;
use App\Services\BaseService;
use Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Notification;
use Session;
use Storage;

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
     * Given signature data, updates the signature for the user in the database.
     * Currently supports both file and base64 upload.
     *
     * @param mixed $user
     * @param mixed $data
     *
     * @return bool
     */
    public function updateSignature($id, $data)
    {
        $user = $this->find($id);
        $bucket = 'signatures';

        if ($data instanceof UploadedFile) {
            $path = $data->store($bucket);
        } else {
            $path = $bucket.'/'.uniqid().'.png';
            Storage::put($path, base64_decode($data));
        }

        $user->written_signature = $path;

        return $user->save();
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
     * Returns the supervisor for a client therapist relationship.
     *
     * @param mixed $patient
     * @param mixed $therapist
     *
     * @return Model
     */
    public function findSupervisor($patient, $therapist)
    {
        $client = $this->find($patient);
        $therapist = $this->find($therapist);

        return $therapist->supervisors()
            ->where('client_id', $client->id)
            ->first();
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

        foreach ($model->getBlindIndexColumn() as $key => $col) {
            if (0 == $key) {
                $this->model->where($col, $searchIndex);
            } else {
                $this->model->orWhere($col, $searchIndex);
            }
        }

        $results = $this->model->paginate();
        $this->resetCriteria();

        return $results;
    }

    /**
     * Enables searching for a user by their encrupted column.
     * and so we must use a blind index.
     *
     * @param string $query
     *
     * @return LengthAwarePaginator
     */
    public function searchencryptedcolumn(string $query, string $column)
    {
        $model = app($this->model());
        $searchIndex = $model->getSearchIndex($query);

        $this->applyCriteria();

        foreach ($model->getBlindIndexColumn() as $key => $col) {
            if ($col == $column) {
                $this->model->where($col, $searchIndex);
            }
        }

        $results = $this->model->paginate();
        $this->resetCriteria();

        return $results;
    }

    /**
     * Removes a Group from a user.
     *
     * @param mixed $group
     * @param mixed $user
     *
     * @return void
     */
    public function removeGroup($group, $user_id)
    {
        $user = $this->find($user_id);
        $user->groups()->detach($group);
    }

    /**
     * Removes a Clinic from a user.
     *
     * @param mixed $clinic
     * @param mixed $user
     *
     * @return void
     */
    public function removeClinic($clinic, $user_id)
    {
        $user = $this->find($user_id);
        $user->clinics()->detach($clinic);
    }

    /**
     * Adds a clinic to a user.
     *
     * @param mixed $clinic
     * @param mixed $user
     *
     * @return void
     */
    public function assignClinic($clinic, $user, $role_id=false)
    {
        $user = $this->find($user);
		if($role_id == false){
			$role_id = $user->roles()->pluck('role_id');
		}
			$user->clinics()->detach($clinic);
			foreach($role_id as $role){
				$user->clinics()->attach($clinic, ['role_id' => $role]);
			}

    }
}
