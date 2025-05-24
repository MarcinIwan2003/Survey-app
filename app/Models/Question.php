<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Survey;
class Question extends Model
{
    protected $fillable = ['survey_id', 'text', 'type', 'read_time', 'answer_time', 'explanation'];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }


}
