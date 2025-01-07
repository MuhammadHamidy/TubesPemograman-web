<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'question',
        'question_desc',
        'image',
        'correct_answer'
    ];

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
