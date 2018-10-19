<?php

namespace App\Models;

use App\Enums\Roles;
use App\Models\Traits\Encryptable;
use App\Models\Traits\Loggable;
use App\Models\Traits\SetsBlindIndex;
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
    use SetsBlindIndex;
    use Uuids;
    use UserPresenter;

    protected $encrypts = [
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'emergency_name',
        'emergency_phone',
        'emergency_relationship',
        'health_card_number',
        'home_phone',
        'license',
        'name',
        'notes',
        'postal_code',
        'province',
        'work_phone',
    ];

    /**
     * The name of the blind index column.
     *
     * @var string
     */
    protected $blindIndex = 'name_bidx';

    /**
     * The name of the column being indexed.
     *
     * @var string
     */
    protected $blindIndexed = 'name';

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
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'doctor_id',
        'email',
        'emergency_name',
        'emergency_phone',
        'emergency_relationship',
        'health_card_number',
        'home_phone',
        'is_active',
        'license',
        'marketing',
        'name',
        'notes',
        'password',
        'phone',
        'postal_code',
        'preferred_contact_method',
        'province',
        'referrer_id',
        'role_id',
        'terms_and_cond',
        'work_phone',
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
     * A client may have a doctor assigned to them.
     *
     * @return BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * A user is associated with many groups.  They are either a therapist of
     * the group or a client of the group.
     *
     * @return BelongsToMany
     */
    public function groups()
    {
        if ($this->isClient()) {
            return $this->belongsToMany(
                Group::class,
                'group_clients',
                'user_id',
                'group_id'
            );
        }

        return $this->belongsToMany(
            Group::class,
            'group_therapists',
            'user_id',
            'group_id'
        );
    }

    /**
     * A user has either notes created for them or notes created by them.
     *
     * @return HasMany
     */
    public function notes()
    {
        if ($this->isClient()) {
            return $this->hasMany(Note::class, 'client_id');
        }

        return $this->hasMany(Note::class, 'therapist_id');
    }

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
     * A client may have been referred to the clinic by a doctor.
     *
     * @return BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(Doctor::class, 'referrer_id');
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
     * Returns the list of supervisors associated to a user.
     *
     * @return BelongsToMany
     */
    public function supervisors()
    {
        return $this
            ->belongsToMany(
                User::class,
                'supervisors',
                'therapist_id',
                'supervisor_id'
            )
            ->withPivot('client_id');
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
     * Check if user has a specific role level.
     *
     * @param int $level
     *
     * @return bool
     */
    public function hasRole(int $level)
    {
        return $this->role->level == $level;
    }

    /**
     * Returns if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasAtLeastRole(Roles::Administrator);
    }

    /**
     * Returns if the user is a client.
     *
     * @return bool
     */
    public function isClient()
    {
        return $this->hasRole(Roles::Client);
    }

    /**
     * Returns if the user is a therapist.
     *
     * @return bool
     */
    public function isTherapist()
    {
        return $this->hasRole(Roles::JuniorTherapist) || $this->hasRole(Roles::SeniorTherapist);
    }

    /**
     * Check if user has at least permission level.
     *
     * @param int $level
     *
     * @return bool
     */
    public function hasAtLeastRole(int $level)
    {
        return $this->role->level >= $level;
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
