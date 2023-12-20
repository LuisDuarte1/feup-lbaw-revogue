<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderCancellation extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'order_cancellation_status',
        'order',
    ];

    protected $casts = [
        'created_date' => 'datetime',
    ];

    public function getOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'order_cancellation');
    }

    protected $table = 'ordercancellations';
}
