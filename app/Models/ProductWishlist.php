<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWishlist extends Model 
{

    protected $fillable = [
        'product',
        'belongsTo'
    ];

    public function product(): HasMany
    {
        return $this->HasMany(Product::class,'ProductWishlist' ,'product','belongsTo');
    }

    public function belongsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongsTo');
    }


    protected $table = 'ProductWishlist';

}