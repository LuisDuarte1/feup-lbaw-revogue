<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payout extends Model{
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';
    protected $fillable = [
        'tax',
        'paidTo',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'tax' => 'float',
        'paidTo' => 'integer'
    ];

    public function paidTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paidTo');
    }

}