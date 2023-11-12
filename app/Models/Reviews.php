<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model {


    const timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'starts',
        'imagePaths',
        'reviewedOrder',
        'reviewer',
        'reviewed'
    ];

    protected $casts = [
        'starts' => 'integer',
        'reviewedOrder' => 'integer',
        'reviewer' => 'integer',
        'reviewed' => 'integer'
    ];

    protected $hidden = [
        'reviewedOrder',
        'reviewer',
        'reviewed'
    ];

    public function reviewedOrder(): HasOne
    {
        return $this->hasOne(Orders::class, 'reviewedOrder');
    }

    public function reviewer(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'reviewer');
    }

    public function reviewed(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'reviewed');
    }

    
}