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
        'profile_picture'
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

    public function parentRelationships()
    {
        return $this->hasMany(ParentChildRelationship::class, 'child_id');
    }

    public function childRelationships()
    {
        return $this->hasMany(ParentChildRelationship::class, 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(User::class, 'parent_child_relationships', 'parent_id', 'child_id');
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_child_relationships', 'child_id', 'parent_id');
    }
}
