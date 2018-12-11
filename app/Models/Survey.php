<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A survey is a collection of questionnaires.
 */
class Survey extends Model
{
    // Log any changes to the survey model
    use Loggable;
    use SetsUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'name'];

    /**
     * Sets the columns that should have a UUID generated.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A survey may have many questionnaires attached to it.
     *
     * @return BelongsToMany
     */
    public function questionnaires()
    {
        return $this->belongsToMany(
            Questionnaire::class,
            'questionnaire_survey',
            'survey_id',
            'questionnaire_id'
        );
    }

    /**
     * A survey may have many responses.
     *
     * @return HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class, 'survey_id');
    }
}
