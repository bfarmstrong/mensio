<?php

namespace App\Models;

use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A doctor is an external user of the system who refers clients for
 * treatment.
 */
class Doctor extends Model
{
    use SetsUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'country',
        'email',
        'is_default',
        'name',
        'notes',
        'phone',
        'postal_code',
        'province',
        'specialty',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A doctor may be assigned to many patients.
     *
     * @return HasMany
     */
    public function patients()
    {
        return $this->hasMany(User::class, 'doctor_id');
    }

    /**
     * A doctor may refer many clients.
     *
     * @return HasMany
     */
    public function referred()
    {
        return $this->hasMany(User::class, 'referrer_id');
    }
}
