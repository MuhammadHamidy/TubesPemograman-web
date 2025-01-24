<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameHistory extends Model
{
    protected $table = 'game_history';
    
    protected $fillable = [
        'user_id',
        'level',
        'correct_answers',
        'total_questions',
        'points_earned',
        'points_before',
        'points_after'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to get success rate
    public function getSuccessRateAttribute()
    {
        return ($this->correct_answers / $this->total_questions) * 100;
    }
} 