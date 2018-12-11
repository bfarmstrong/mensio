<?php

namespace App\Models;

use App\Models\Traits\Encryptable;
use App\Models\Traits\SetsUuids;
use App\Models\Traits\Signable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An attachment is a file that is added to a user profile.
 */
class Attachment extends Model
{
    use Encryptable;
    use SetsUuids;
    use Signable;

    /**
     * The fields that are encrypted in the database.
     *
     * @var array
     */
    protected $encrypts = [
        'file_location',
        'file_name',
        'file_size',
        'mime_type',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clinic_id',
        'file_location',
        'file_name',
        'file_size',
        'group_id',
        'mime_type',
        'therapist_id',
        'user_id',
    ];

    /**
     * The attributes that are signed.
     *
     * @var array
     */
    protected $signable = [
        'clinic_id',
        'file_location',
        'file_name',
        'file_size',
        'group_id',
        'mime_type',
        'user_id',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * An attachment is for a user in a specific clinic.
     *
     * @return BelongsTo
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * An attachment is for a specific user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Returns the value that is used to sign the attachment.
     *
     * @return string
     */
    public function getSignee()
    {
        return $this->therapist_id;
    }
}
