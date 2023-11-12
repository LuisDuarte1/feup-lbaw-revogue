<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    use HasFactory;

    const CREATED_AT = "creationDate";
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'orderStatus'
    ];

    public function notifications(): HasMany
    {
        return $this->hasMany(Notifications::class, 'orderId');
    }
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'creationDate' => 'datetime',
    ];

    public function products() {
        return $this->belongsToMany(Product::class, 'OrderProduct', 'orderId', 'product')->withPivot('discount');
    }

    protected $table = 'Order';

}
