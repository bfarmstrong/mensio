<?php

namespace App\Models;

use App\Models\Traits\Encryptable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A communication log is a representation of an encounter with a client.  It
 * is a shorter note which contains the reason for the encounter and any extra
 * notes that apply to that meeting.
 */
class CommunicationLog extends Model
{
    use Encryptable;
    use SetsUuids;

    /**
     * The fields that should be encrypted.
     *
     * @var array
     */
    protected $encrypts = [
        'notes',
        'reason',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appointment_date',
        'notes',
        'reason',
        'clinic_id',
        'therapist_id',
        'user_id',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A communication log may be attached to a clinic.
     *
     * @return BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * A therapist creates a communication log.
     *
     * @return BelongsTo
     */
    public function therapist()
    {
        return $this->belongsTo(Therapist::class, 'therapist_id');
    }

    /**
     * A communication log is created for a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
