<?php

// TypeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class PriceFilter
{
    public function filter(Builder $builder, $value)
    {

        if (is_array($value) && isset($value['min_price']) && isset($value['max_price'])) {

            return $builder->whereBetween('price', [$value['min_price'], $value['max_price']]);
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
