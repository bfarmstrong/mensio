<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A document is a collection of questionnaires.
 */
class Document extends Model
{
    // Log any changes to the document model
    use Loggable;
    use SetsUuids;

  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =  ['name', 
							'file_location',
							'file_name',
							'file_size',
							'mime_type',
							'user_id',
							'description',
							'date',
							'document_type',
							'clinic_id',
							'document_type_id',
							'digital_signature'
							];
	
    /**
     * Sets the columns that should have a UUID generated.
     *
     * @var array
     */
    protected $uuids = ['uuid'];
	
	/**
     * A document may have many users attached to it.
     *
     * @return BelongsTo
     */
    public function users()
    {

		return $this->belongsTo(User::class, 'user_id');
    }
	
	/**
     * A document may have many clinics attached to it.
     *
     * @return BelongsTo
     */
    public function clinics()
    {

		return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
