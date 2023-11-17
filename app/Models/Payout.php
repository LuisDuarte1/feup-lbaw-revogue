<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payout extends Model
{
    use HasFactory;
    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'tax',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'tax' => 'float',
    ];

    public function paidTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_to');
    }

    protected $table = 'payouts';
}
