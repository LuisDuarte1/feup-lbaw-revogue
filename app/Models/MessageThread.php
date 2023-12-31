<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MessageThread extends Model
{
    use HasFactory;

    const CREATED_AT = null;

    const UPDATED_AT = 'last_updated';

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $primaryKey = 'id';

    protected $fillable = [
        'type',
        'user_1',
        'user_2',
        'product',
        'order',
    ];

    protected $casts = [
        'sent_date' => 'datetime',
    ];

    public function firstUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_1');
    }

    public function secondUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_1');
    }

    public function messageProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product');
    }

    public function messageOrder(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'message_thread');
    }

    public function messageThreadReport(): HasOne
    {
        return $this->hasOne(Report::class, 'message_thread');
    }

    protected $table = 'messagethread';
}
