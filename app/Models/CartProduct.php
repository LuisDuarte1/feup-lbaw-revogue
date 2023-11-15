<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProduct extends Pivot
{
    public $timestamps = false;

    public function appliedVoucher(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'appliedVoucher');
    }

    protected $table = 'CartProduct';
}
