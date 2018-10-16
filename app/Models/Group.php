<?php

namespace App\Models;

use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A group is a collection of therapists and patients.
 */
class Group extends Model
{
    use SetsUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A group may have many clients associated with it.
     *
     * @return BelongsToMany
     */
    public function clients()
    {
        return $this->belongsToMany(
            User::class,
            'group_clients',
            'group_id',
            'user_id'
        );
    }

    /**
     * A group may have many therapists associated with it.
     *
     * @return BelongsToMany
     */
    public function therapists()
    {
        return $this->belongsToMany(
            User::class,
            'group_therapists',
            'group_id',
            'user_id'
        );
    }
}
