<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    const CREATED_AT = "creation_date";
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
        'image_Path',

    ];  

    protected $casts = [
        'creation_date' => 'datetime',
        'price' => 'float',

    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attributes::class,'ProductAttributes', 'attribute_id' , 'product_id');	
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Messages::class, 'subjectProduct');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Vouchers::class, 'product');
    }

    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'Products';

}