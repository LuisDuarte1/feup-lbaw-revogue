<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class FederalAuthentication extends Model 
{   
   
    const timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'provider',
        'refresh_token',
        'access_token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    protected $table = 'FederalAuthentication';
}