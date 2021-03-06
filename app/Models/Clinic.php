<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Clinic extends Model
{
    use Loggable;
    use Notifiable;
    use SetsUuids;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clinics';

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
        'logo',
        'postal_code',
        'province',
        'name',
        'subdomain',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * return user if in user groups.
     *
     * @param string user_id
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_clinics', 'clinic_id', 'user_id');
    }
}
