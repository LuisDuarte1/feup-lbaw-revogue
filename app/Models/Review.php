<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory;

    const CREATED_AT = 'sent_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'stars',
        'image_paths',
        'description',
        'reviewer',
        'reviewed',
    ];

    protected $casts = [
        'stars' => 'float',
        'sent_date' => 'datetime',
        'image_paths' => 'array',
    ];

    public function reviewedOrder(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'reviewed_order');
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
        return $this->hasOne(Notification::class, 'review');
    }

    protected $table = 'reviews';
}
