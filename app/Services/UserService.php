<?php

namespace App\Services;

use App\Events\UserRegisteredEmail;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ActivateUserEmail;
use App\Services\Traits\HasRoles;
use Auth;
use DB;
use Exception;
use Illuminate\Support\Facades\Schema;
use Session;

class UserService
{
    use HasRoles;

    /**
     * User model.
     *
     * @var User
     */
    public $model;

    /**
     * Role Service.
     *
     * @var RoleService
     */
    protected $role;

    public function __construct(User $model, Role $role)
    {
        $this->model = $model;
        $this->role = $role;
    }

    /**
     * Get all users.
     *
     * @return array
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find a user.
     *
     * @param int $id
     *
     * @return User
     */
    public function find($id)
    {
        $user = $this->model->find($id);
        activity()->performedOn($user)->log('viewed');

        return $user;
    }

    /**
     * Search the users.
     *
     * @param string $input
     *
     * @return mixed
     */
    public function search($input)
    {
        $query = $this->model->orderBy('created_at', 'desc');

        $columns = Schema::getColumnListing('users');

        foreach ($columns as $attribute) {
            $query->orWhere($attribute, 'LIKE', '%'.$input.'%');
        }

        activity()
            ->withProperties([
                'search_table' => 'users',
                'search_term' => $input,
            ])
            ->log('searched');

        return $query->paginate(env('PAGINATE', 25));
    }

    /**
     * Find a user by email.
     *
     * @param string $email
     *
     * @return User
     */
    public function findByEmail($email)
    {
        $user = $this->model->findByEmail($email);
        activity()->performedOn($user)->log('viewed');

        return $user;
    }

    /**
     * Find by Role ID.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function findByRoleID($id)
    {
        $usersWithRepo = [];
        $users = $this->model->all();

        foreach ($users as $user) {
            if ($user->role->first()->id == $id) {
                $usersWithRepo[] = $user;
            }
        }

        return $usersWithRepo;
    }

    /**
     * Find by the user meta activation token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function findByActivationToken($token)
    {
        return $this->model->where('activation_token', $token)->first();
    }

    /**
     * Create a user's profile.
     *
     * @param User   $user      User
     * @param string $password  the user password
     * @param string $role      the role of this user
     * @param bool   $sendEmail Whether to send the email or not
     *
     * @return User
     */
    public function create($user, $password, $role = 'client', $sendEmail = false)
    {
        try {
            DB::transaction(function () use ($user, $password, $role, $sendEmail) {
                $this->assignRole($role, $user->id);

                if ($sendEmail) {
                    event(new UserRegisteredEmail($user, $password));
                }
            });

            // TOOD: Look at this
            // $this->setAndSendUserActivationToken($user);

            return $user;
        } catch (Exception $e) {
            throw new Exception('We were unable to generate your profile, please try again later.', 1);
        }
    }

    /**
     * Update a user's profile.
     *
     * @param int   $userId User Id
     * @param array $inputs UserMeta info
     *
     * @return User
     */
    public function update($userId, $payload)
    {
        if (! isset($payload['terms_and_cond'])) {
            throw new Exception('You must agree to the terms and conditions.', 1);
        }

        try {
            return DB::transaction(function () use ($userId, $payload) {
                $user = $this->model->find($userId);

                if (isset($payload['marketing']) && (1 == $payload['marketing'] || 'on' == $payload['marketing'])) {
                    $payload['marketing'] = 1;
                } else {
                    $payload['marketing'] = 0;
                }

                if (isset($payload['terms_and_cond']) && (1 == $payload['terms_and_cond'] || 'on' == $payload['terms_and_cond'])) {
                    $payload['terms_and_cond'] = 1;
                } else {
                    $payload['terms_and_cond'] = 0;
                }

                $user->update($payload);

                if (isset($payload['role'])) {
                    $this->assignRole($payload['role'], $userId);
                }

                return $user;
            });
        } catch (Exception $e) {
            throw new Exception('We were unable to update your profile', 1);
        }
    }

    /**
     * Invite a new member.
     *
     * @param array $info
     *
     * @return void
     */
    public function invite($info)
    {
        $password = substr(md5(rand(1111, 9999)), 0, 10);

        return DB::transaction(function () use ($password, $info) {
            $user = $this->model->create([
                'email' => $info['email'],
                'name' => $info['name'],
                'password' => bcrypt($password),
            ]);

            return $this->create($user, $password, $info['role'], true);
        });
    }

    /**
     * Destroy the profile.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $this->unassignAllRoles($id);

                return $this->model->find($id)->delete();
            });
        } catch (Exception $e) {
            throw new Exception('We were unable to delete this profile', 1);
        }
    }

    /**
     * Switch user login.
     *
     * @param int $id
     *
     * @return bool
     */
    public function switchToUser($id)
    {
        try {
            $user = $this->model->find($id);
            Session::put('original_user', Auth::id());
            activity()
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->log('switched to');
            Auth::login($user);

            return true;
        } catch (Exception $e) {
            throw new Exception('Error logging in as user', 1);
        }
    }

    /**
     * Switch back.
     *
     * @param int $id
     *
     * @return bool
     */
    public function switchUserBack()
    {
        try {
            $original = Session::pull('original_user');
            $user = $this->model->find($original);
            activity()
                ->causedBy($user)
                ->performedOn(Auth::user())
                ->log('switched back');
            Auth::login($user);

            return true;
        } catch (Exception $e) {
            throw new Exception('Error returning to your user', 1);
        }
    }

    /**
     * Set and send the user activation token via email.
     *
     * @param void
     */
    public function setAndSendUserActivationToken($user)
    {
        $token = md5(str_random(40));

        $user->update([
            'activation_token' => $token,
        ]);

        $user->notify(new ActivateUserEmail($token));
    }
}
