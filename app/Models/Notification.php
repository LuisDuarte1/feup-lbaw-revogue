<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'read',
        'dismissed',
        'type',
        "order_id",
        "wishlist_product",
        "cart_product",
        "review",
        "message",
        "sold_product"
    ];

    protected $casts = [
        'read' => 'boolean',
        'dismissed' => 'boolean',
    ];

    public function notificationBelongsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongs_to');
    }

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id');
    }

    /*public function productWishlist(): BelongsTo
    {
        return $this->BelongsTo(ProductWishlist::class, 'wishlistProduct');
    }*/

    public function cartProduct(): BelongsTo
    {
        return $this->BelongsTo(CartProduct::class, 'cart_product');
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'review');
    }

    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'message');
    }

    protected $table = 'notifications';
}
