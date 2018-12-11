<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use App\Models\Traits\SetsUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A questionnaire is a query with a selection of answers (if applicable.)  May
 * also accept a plaintext answer.
 */
class Question extends Model
{
    // Log all changes to the question model.
    use Loggable;
    use SetsUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label',
        'name',
        'questionnaire_id',
        'rules',
        'type',
    ];

    /**
     * The columns that generate a UUID.
     *
     * @var array
     */
    protected $uuids = ['uuid'];

    /**
     * A question has many answers.
     *
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    /**
     * A question may have a grid layout.
     *
     * @return HasMany
     */
    public function questionGrid()
    {
        return $this->hasMany(QuestionGrid::class, 'question_id');
    }

    /**
     * A question has many items.
     *
     * @return HasMany
     */
    public function questionItems()
    {
        return $this->hasMany(QuestionItem::class, 'question_id');
    }

    /**
     * A question belongs to a questionnaire.
     *
     * @return BelongsTo
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }
}
