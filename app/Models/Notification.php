<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    const CREATED_AT = 'creationDate';
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'read',
        'dismissed',
        'type'
    ];

    protected $casts = [
        'read' => 'boolean',
        'dismissed' => 'boolean',
    ];

    public function notificationBelongsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongsTo');
    }

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'orderId');
    }

    /*public function productWishlist(): BelongsTo
    {
        return $this->BelongsTo(ProductWishlist::class, 'wishlistProduct');
    }*/

    public function cartProduct(): BelongsTo
    {
        return $this->BelongsTo(CartProduct::class, 'cartProduct');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'review');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'message');
    }

    protected $table = 'Notifications';

}