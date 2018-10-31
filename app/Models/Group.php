<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Loggable;
    use SetsUuids;

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:groups',
    ];

    /**
     * Sets the columns that should have a UUID generated.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * Find a group by name.
     *
     * @param string $name
     *
     * @return group
     */
    public static function findByName($name)
    {
        return Group::where('name', $name)->firstOrFail();
    }
	/**
    * return user if in user groups.
    *
    * @param string user_id
    */
	public function users()
    {
        return $this->belongsToMany('App\Models\User','user_groups','group_id','user_id');
    }
}
