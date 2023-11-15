<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
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
        'email',
        'password',
        'profileImagePath',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'creationDate' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Admins';
}
