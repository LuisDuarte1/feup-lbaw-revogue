<?php

// SizeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class SizeFilter
{
    public function filter(Builder $builder, $value)
    {

        $builder->join('productattributes', 'products.id', '=', 'productattributes.product')
            ->join('attributes', 'productattributes.attribute', '=', 'attributes.id')
            ->where('attributes.key', 'Size')
            ->where('attributes.value', $value);

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
