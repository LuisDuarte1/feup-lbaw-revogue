<?php

// ProductFilter.php

namespace App\Filters;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'size' => SizeFilter::class,
        'price' => PriceFilter::class,
    ];
}
