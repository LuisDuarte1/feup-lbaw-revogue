<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';
    
    protected $fillable = ['method'];

    function orders(): HasMany{
        return $this->hasMany(Order::class, "purchase");
    }

    protected $table = 'purchases';
}
