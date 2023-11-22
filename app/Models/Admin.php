<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'creation_date';

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
        'profile_image_path',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';
}
