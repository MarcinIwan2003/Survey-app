<?php

namespace App\Models;
use App\Models\Question;
use App\Models\User;
use App\Models\QuizSession;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['title', 'user_id', 'code'];

public function questions()
{
    return $this->hasMany(Question::class);
}
public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sessions(): HasMany
    {
        return $this->hasMany(QuizSession::class);
    }
}
