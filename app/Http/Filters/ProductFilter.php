<?php

// ProductFilter.php

namespace App\Http\Filters;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'attribute' => AttributeFilter::class,
        'price' => PriceFilter::class,
        'category' => CategoryFilter::class,
    ];
}
