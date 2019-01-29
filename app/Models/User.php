<?php

namespace App\Models;

use App\Enums\Roles;
use App\Models\Traits\Anonymize;
use App\Models\Traits\Loggable;
use App\Models\Traits\SetsBlindIndex;
use App\Models\Traits\Uuids;
use App\Notifications\ResetPassword;
use App\Presenters\UserPresenter;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Anonymize;
    use Loggable;
    use Notifiable;
    use SetsBlindIndex;
    use Uuids;
    use UserPresenter;
    use SoftDeletes;

    /**
     * The columns that should be anonymized.
     *
     * @var array
     */
    protected $anonymize = [
        'address_line_1' => 'streetAddress',
        'city' => 'city',
        'email' => 'safeEmail',
        'emergency_name' => 'name',
        'emergency_phone' => 'phoneNumber',
        'health_card_number' => 'randomNumber',
        'home_phone' => 'phoneNumber',
        'license' => 'randomNumber',
        'name' => 'name',
        'postal_code' => 'postcode',
        'work_phone' => 'phoneNumber',
    ];

    /**
     * The name of the blind index column.
     *
     * @var string
     */
    protected $blindIndex = ['name_bidx', 'health_card_number_bidx'];

    /**
     * The name of the column being indexed.
     *
     * @var string
     */
    protected $blindIndexed = ['name', 'health_card_number'];

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
        'written_signature',
		'gender',
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

		if ($this->roles()->where('level', $level)->first()) {
			return true;
		}
			return false;
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
     * Returns if the user is an admin.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasAtLeastRole(Roles::Super);
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
		foreach($this->roles()->pluck('roles.id') as $roles){
			if($roles >= $level){
				return true;
			}
		}
		return false;
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

    /**
     * return group if in user groups.
     *
     * @param string group_id
     */
    public function groups()
    {
        return $this->belongsToMany('App\Models\Group', 'user_groups', 'user_id', 'group_id');
    }

    /**
     * return clinic if in user xlinix.
     *
     * @param string clinic_id
     */
    public function clinics()
    {
        return $this->belongsToMany('App\Models\Clinic', 'user_clinics', 'user_id', 'clinic_id');
    }
	
	/**
     * return clinic if in user xlinix.
     *
     * @param string clinic_id
     */
    public function surveys()
    {
		return $this->hasMany(Survey::class, 'user_id');
    }
	
	public function user_surveys()
    {
        return $this->belongsToMany('App\Models\Survey', 'user_surveys', 'user_id', 'survey_id');
  }
  
	/**
     * return roles if in user xlinix.
     *
     * @param string role_id
    */
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_clinics', 'user_id', 'role_id');
    }
}
