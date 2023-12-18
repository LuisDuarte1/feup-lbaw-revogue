<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bargain extends Model
{
    use HasFactory;

    const CREATED_AT = 'created_date';

    const UPDATED_AT = null;

    protected $primaryKey = 'id';

    protected $fillable = [
        'bargain_status',
        'proposed_price',
        'product',
    ];

    protected $casts = [
        'created_date' => 'datetime',
        'proposed_price' => 'float',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'bargain');
    }

    public function voucher(): HasOne
    {
        return $this->hasOne(Voucher::class, 'bargain');
    }

    public function getProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product');
    }

    protected $table = 'bargains';
}
