<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    // Don't add create and update timestamps in database.
    const CREATED_AT = "creationDate";
    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'price',
        'imagePath'
    ];  

    protected $casts = [
        'creationDate' => 'datetime',
        'price' => 'float'
    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attributes::class,'ProductAttributes', 'attribute' , 'product');	
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'subjectProduct');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Vouchers::class, 'product');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Reviews::class, 'product');
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'ProductWishlist', 'product' , 'belongsTo');	
    }
    

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'OrderProduct', 'product', 'orderId');
    }

    public function inCart(): BelongsToMany
    {
        return $this->belongsToMany(CartProduct::class, 'CartProduct', 'product', 'belongsTo')->withPivot('appliedVoucher');
    }
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Products';

}