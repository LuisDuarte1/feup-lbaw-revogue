<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductWishlist extends Model 
{
    public $timestamps = false;
    
    protected $fillable = [
        'product',
        'belongsTo'
    ];

    public function product(): HasMany
    {
        return $this->HasMany(Product::class,'product');
    }

    public function wishlistBelongsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongsTo');
    }

    public function notification(): HasMany
    {
        return $this->HasMany(Notification::class,'wishlistProduct');
    }

    protected $table = 'ProductWishlist';

}