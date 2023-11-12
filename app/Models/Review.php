<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model {


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
        return $this->hasOne(Order::class, 'reviewedOrder');
    }

    public function reviewer(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'reviewer');
    }

    public function reviewed(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'reviewed');
    }

    public function notifications(): HasOne
    {
        return $this->hasOne(Notifications::class, 'review');
    }

    protected $table = 'Reviews';
    
}