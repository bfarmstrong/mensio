<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A single answer as part of a response to a questionnaire.
 */
class Answer extends Model
{
    // Log all changes to the answer model.
    use Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'question_item_id',
        'response_id',
        'value',
    ];

    /**
     * An answer is tied to a question.
     *
     * @return BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * An answer may be tied to a question item.
     *
     * @return BelongsTo
     */
    public function questionItem()
    {
        return $this->belongsTo(QuestionItem::class, 'question_item_id');
    }

    /**
     * An answer is part of a response.
     *
     * @return BelongsTo
     */
    public function response()
    {
        return $this->belongsTo(Response::class, 'response_id');
    }
}
