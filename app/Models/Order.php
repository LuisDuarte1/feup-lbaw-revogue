<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'status',
        'shipping_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creation_date' => 'datetime',
        'shipping_address' => 'array',
    ];

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orderproduct', 'order_id', 'product')->withPivot('discount');
    }

    public function reviewedOrder(): HasOne
    {
        return $this->hasOne(Review::class, 'reviewed_order');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongs_to');
    }

    protected $table = 'orders';
}
