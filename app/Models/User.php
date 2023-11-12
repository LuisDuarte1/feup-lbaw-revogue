<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

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
        'password',
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
        return $this->hasMany(Message::class, 'fromUser');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'soldBy');
    }

    public function reviewing(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer');
    }

    public function reviewed(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed');
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
