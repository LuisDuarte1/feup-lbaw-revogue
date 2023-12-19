<?php

namespace App\Models;

use App\Filters\ProductFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    const CREATED_AT = 'creation_date';

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
        'image_paths',
    ];

    protected $casts = [
        'creation_date' => 'datetime',
        'price' => 'float',
        'image_paths' => 'array',
    ];

    protected $hidden = [
        'fts_search',
    ];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'productattributes', 'product', 'attribute');
    }

    public function soldBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sold_by');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'subject_product');
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class, 'product');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product');
    }

    public function wishlist(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'productwishlist', 'product', 'belongs_to');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'orderproduct', 'product', 'order_id')->withPivot('discount');
    }

    public function inCart(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'cartproduct', 'product', 'belongs_to')->using(CartProduct::class);
    }

    public function report(): HasMany
    {
        return $this->hasMany(Report::class, 'product');
    }

    public function cartProducts(): BelongsToMany
    {
        return $this->belongsToMany(CartProduct::class, 'cartproduct', 'product', 'belongs_to')->using(CartProduct::class);
    }

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function purchaseIntents(): BelongsToMany
    {
        return $this->belongsToMany(PurchaseIntent::class, 'purchaseintentproduct', 'product', 'purchase_intent');
    }

    public function scopeFilter(Builder $builder, $request)
    {
        /* $namespace = 'App\\Filters';
         $filter = new FilterBuilder($builder, $request, $namespace);*/

        return (new ProductFilter($request))->filter($builder);
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
}
