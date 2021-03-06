<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A response from a user to a questionnaire.  Contains all of the answers to
 * that questionnaire.
 */
class Response extends Model
{
    // Log all changes to the response model.
    use Loggable;
    use SetsUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'complete',
        'clinic_id',
        'data',
        'group_id',
        'questionnaire_id',
        'survey_id',
        'user_id',
        'uuid',
    ];

    /**
     * Sets the columns that should have a UUID generated.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A response has many answers.
     *
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'response_id');
    }

    /**
     * A response is part of a questionnaire.
     *
     * @return BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }

    /**
     * A response is part of a Clinic.
     *
     * @return BelongsTo
     */
    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * A response may be assigned to a group.
     *
     * @return BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * A response is part of a survey.
     *
     * @return BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id');
    }

    /**
     * A response is owned by a user.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
