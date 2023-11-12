<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    const CREATED_AT = 'creationDate';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'read',
        'dismissed',
        'notificationType',
        'belongsTo',
        'orderId',
        'wishlistProduct',
        'cartProduct',
        'review',
        'message',
    ];

    protected $casts = [
        'read' => 'boolean',
        'dismissed' => 'boolean',
        'belongsTo' => 'integer', 
        'orderId' => 'integer',
        'wishlistProduct' => 'integer',
        'cartProduct' => 'integer',
        'review' => 'integer',
        //'notificationType' => 'integer', qual é o type?
        'message' => 'integer',
    ];

    protected $hidden = [
        'notificationTo'
    ];

    public function notificationTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'notificationTo');
    }

    public function orderId(): BelongsTo
    {
        return $this->BelongsTo(Orders::class, 'orderId');
    }

    public function ProductWishlist(): BelongsTo
    {
        return $this->BelongsTo(ProductWishlist::class, 'wishlistProduct');
    }

    public function cartProduct(): BelongsTo
    {
        return $this->BelongsTo(cartProduct::class, 'cartProduct');
    }

    public function review(): HasOne
    {
        return $this->HasOne(Reviews::class, 'review');
    }

    public function message(): HasOne
    {
        return $this->HasOne(Messages::class, 'message');
    }

    protected $table = 'Notifications';

}