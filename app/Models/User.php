<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mother_name',
        'age',
        'password',
        'role',
        'points',
        'parent_email',
        'parent_password',
        'is_parent',
        'parent_of'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'age' => 'integer'
        ];
    }

    public function child()
    {
        return $this->belongsTo(User::class, 'parent_of');
    }

    public function parent()
    {
        return $this->hasOne(User::class, 'parent_of');
    }
}
