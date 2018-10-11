<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\Purifiable;
use App\Models\Traits\SetsUuids;
use App\Models\Traits\Signable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A note is information that is created about a client in regard to an
 * encounter of some form.  Supports HTML format.
 */
class Note extends Model
{
    // Log all changes to the notes model.
    use Loggable;
    use Purifiable;
    use SetsUuids;
    use Signable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'contents',
        'digital_signature',
        'is_draft',
        'note_id',
        'therapist_id',
    ];

    /**
     * The content that is cleaned of any unsafe HTML.
     *
     * @var array
     */
    protected $purifiable = [
        'contents',
    ];

    /**
     * The attributes that are signed.
     *
     * @var array
     */
    protected $signable = [
        'client_id',
        'contents',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A note may have many children notes under it.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Note::class, 'note_id');
    }

    /**
     * A note is created for a client.
     *
     * @return BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * A note may or may not have a parent note.
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }

    /**
     * A note is created by a therapist.
     *
     * @return BelongsTo
     */
    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    /**
     * Returns the value that is used to sign the note.
     *
     * @return string
     */
    public function getSignee()
    {
        return $this->therapist_id;
    }
}
