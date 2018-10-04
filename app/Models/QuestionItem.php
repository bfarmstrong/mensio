<?php

namespace App\Models;

use App\Models\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A question item is a pre-defined answer to a question.
 */
class QuestionItem extends Model
{
    // Log all changes to the question item model.
    use Loggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'question_id', 'value'];

    /**
     * A question item is used in many answers.
     *
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_item_id');
    }

    /**
     * A question item belongs to a question.
     *
     * @return BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
