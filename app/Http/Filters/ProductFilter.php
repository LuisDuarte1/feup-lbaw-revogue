<?php

// ProductFilter.php

namespace App\Filters;

class ProductFilter extends AbstractFilter
{
    protected $filters = [
        'type' => TypeFilter::class,
    ];
}
