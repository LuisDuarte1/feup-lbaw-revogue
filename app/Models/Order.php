<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    const CREATED_AT = 'creationDate';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'orderStatus',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creationDate' => 'datetime',
    ];

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'orderId');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'OrderProduct', 'orderId', 'product')->withPivot('discount');
    }

    public function reviewedOrder(): HasOne
    {
        return $this->hasOne(Review::class, 'reviewedOrder');
    }

    protected $table = 'Orders';
}
