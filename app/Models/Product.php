<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    const CREATED_AT = "creationDate";
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
        'imagePath',

    ];  

    protected $casts = [
        'creationDate' => 'datetime',
        'price' => 'float',

    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attributes::class,'ProductAttributes', 'attribute' , 'product');	
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'soldBy');
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