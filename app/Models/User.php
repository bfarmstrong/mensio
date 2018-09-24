<?php

namespace App\Models;

use App\Models\Traits\Encryptable;
use App\Models\Traits\Loggable;
use App\Models\Traits\Uuids;
use App\Notifications\ResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Loggable;
    use Notifiable;
    use Encryptable;
    use Uuids;

    protected $encrypts = [
        'name',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activation_token',
        'email',
        'is_active',
        'marketing',
        'name',
        'password',
        'phone',
        'terms_and_cond',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Turn off laravel's auto incrementing built-in feature.
     */
    public $incrementing = false;

    /**
     * User Roles.
     *
     * @return Relationship
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has role.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role->name == $role;
    }

    /**
     * Check if user has at least permission level.
     *
     * @param int $role
     *
     * @return bool
     */
    public function hasAtLeastRole($role)
    {
        $requiredLevel = Role::getLevelByName($role);

        return $this->role()->first()->level >= $requiredLevel;
    }

    /**
     * Find by Email.
     *
     * @param string $email
     *
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
