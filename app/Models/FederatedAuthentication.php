<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class FederatedAuthentication extends Model 
{   
   use HasApiTokens;
   
    public $timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'provider',
        'refreshToken',
        'accessToken'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    protected $table = 'FederatedAuthentications';
}