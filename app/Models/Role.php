<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Loggable;
    use SetsUuids;

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * Fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'level',
        'name',
        'permissions',
        'protected',
    ];

    /**
     * Sets the columns that should have a UUID generated.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * Rules.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|unique:roles',
        'label' => 'required',
    ];

    // /**
    //  * A Roles users
    //  *
    //  * @return Relationship
    //  */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Find a role by name.
     *
     * @param string $name
     *
     * @return Role
     */
    public static function findByName($name)
    {
        return Role::where('name', $name)->firstOrFail();
    }

    public static function getLevelByName($name)
    {
        return Role::where('name', $name)->firstOrFail()->level;
    }
}
