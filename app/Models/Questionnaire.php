<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A questionnaire is a collection of questions and responses.
 */
class Questionnaire extends Model
{
    // Log any changes to the questionnaire model
    use Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['data', 'description', 'name', 'scoring_method'];

    /**
     * A questionnaire has many questions assigned to it.
     *
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'questionnaire_id');
    }

    /**
     * A questionnaire may have many responses.
     *
     * @return HasMany
     */
    public function responses()
    {
        return $this->hasMany(Response::class, 'questionnaire_id');
    }

    /**
     * A questionnaire has many surveys attached to it.
     *
     * @return BelongsToMany
     */
    public function surveys()
    {
        return $this->belongsToMany(
            Survey::class,
            'questionnaire_survey',
            'questionnaire_id',
            'survey_id'
        );
    }
}
