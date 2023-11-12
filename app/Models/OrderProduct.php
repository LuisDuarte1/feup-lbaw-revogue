<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'orderId', 
        'product', 
        'discount'
    ];

    protected $table = "OrderProduct";
}
