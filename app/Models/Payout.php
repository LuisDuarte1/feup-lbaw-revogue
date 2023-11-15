<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';
    protected $fillable = [
        'tax'
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'tax' => 'float'
    ];

    public function paidTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paidTo');
    }

    
    protected $table = 'Payouts';
}