<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialVideo extends Model
{
    protected $fillable = [
        'title',
        'file_path',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
} 