<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartProduct extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product',
        'belongsTo',
        'appliedVoucher'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product')->withPivot('appliedVoucher');
    }

    public function cartBelongsTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'belongsTo');
    }

    public function appliedVoucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'appliedVoucher');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'cartProduct');
    }

    protected $table = "CartProduct";
}