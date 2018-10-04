<?php

namespace App\Models;

use App\Models\Traits\Encryptable;
use App\Models\Traits\Loggable;
use App\Models\Traits\Uuids;
use App\Notifications\ResetPassword;
use App\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Loggable;
    use Notifiable;
    use Encryptable;
    use Uuids;
    use UserPresenter;

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
     * Indicates that users are keyed by a string.
     *
     * @var string
     */
    protected $keyType = 'string';

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
     * Returns the list of patients associated to a user.
     *
     * @return BelongsToMany
     */
    public function patients()
    {
        return $this->belongsToMany(
            User::class,
            'therapist_patient',
            'therapist_id',
            'patient_id'
        );
    }

    /**
     * A user has many responses to questionnaires.
     *
     * @return HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class, 'user_id');
    }

    /**
     * User Roles.
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Returns the list of therapists associated to a user.
     *
     * @return BelongsToMany
     */
    public function therapists()
    {
        return $this->belongsToMany(
            User::class,
            'therapist_patient',
            'patient_id',
            'therapist_id'
        );
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
     * Returns if the user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return $this->hasRole('client');
    }

    /**
     * Returns if the user is a therapist.
     *
     * @return bool
     */
    public function isTherapist()
    {
        return $this->hasRole('therapist1') || $this->hasRole('therapist2');
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

        return $this->role->level >= $requiredLevel;
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
