<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PurchaseIntent extends Model
{
    const CREATED_AT = 'creation_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'shipping_address', 
        'payment_intent_id'
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user');
    }

    public function products(): BelongsToMany{
        return $this->belongsToMany(Product::class, 'purchaseintentproduct', 'purchase_intent', 'product');
    }

    protected $table = "purchaseintents";
}
