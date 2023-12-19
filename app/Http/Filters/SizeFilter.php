<?php

// SizeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class SizeFilter
{
    public function filter(Builder $query, $value)
    {

        $query->join('ProductAttributes', 'Products.id', '=', 'ProductAttributes.product')
            ->where('ProductAttributes.attribute', $value);

        return $query;
    }
}
