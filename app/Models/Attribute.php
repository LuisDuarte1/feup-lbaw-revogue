<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attribute extends Model
{
    public $timestamps = false;

    protected $primarykey = 'id';

    protected $fillable = [
        'key',
        'value',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'ProductAttributes', 'product', 'attribute');
    }

    protected $table = 'Attributes';
}
