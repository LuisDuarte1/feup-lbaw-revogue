<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'creationDate';
    const UPDATED_AT = null;

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'username',
        'displayName',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'settings',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creationDate' => 'datetime',
        'password' => 'hashed',
        'settings' => 'array',
    ];


    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'fromUser');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'toUser');
    }

    public function reviewing(): HasMany
    {
        return $this->hasMany(Reviews::class, 'reviewer');
    }

    public function reviewed(): HasMany
    {
        return $this->hasMany(Reviews::class, 'reviewed');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, 'toUser');
    }




    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Users';
}
