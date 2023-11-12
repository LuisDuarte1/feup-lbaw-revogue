<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'product',
        'belongsTo',
        'appliedVoucher'
    ];

    protected $table = "CartProduct";
}