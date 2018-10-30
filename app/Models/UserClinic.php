<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A user information that is assign for clinic in regard to an
 * encounter of some form.  Supports HTML format.
 */
class UserClinic extends Model
{
    // Log all changes to the Clinic model.
    use Loggable;
    use SetsUuids;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
        'clinic_id',
    ];

    /**
     * A UserClinic may have many children clinic under it.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(UserClinic::class, 'clinic_id');
    }

    /**
     * A UserClinic is created for a user.
     *
     * @return BelongsTo
     */
    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

	
    /**
     * A UserClinic is created for a user.
     *
     * @return BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
