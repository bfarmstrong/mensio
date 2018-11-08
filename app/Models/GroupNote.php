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
 * A note is information that is created about a group in regard to an
 * encounter of some form.  Supports HTML format.
 */
class GroupNote extends Model
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
        'contents',
        'digital_signature',
        'is_draft',
        'group_id',
        'note_id',
        'created_by',
        'clinic_id',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

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
        'contents',
    ];

    /**
     * A GroupNote may have many children notes under it.
     *
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(GroupNote::class, 'note_id');
    }

    /**
     * A GroupNote is created for a group.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * A note may or may not have a parent note.
     *
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * A GroupNote is created for a user.
     *
     * @return BelongsTo
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
