<?php

// TypeFilter.php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PriceFilter
{
    /*public function filter(Request $request, Builder $query)
    {
        dd($request->min_price, $request->max_price);
        if ($request->min_price && $request->max_price) {
            // ...

            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        return $query;

        //$products = $query->paginate(20);

        // return view('products.index', compact('products'))->render();
    }*/

    public function filter(Builder $builder, $value)
    {

        if (is_array($value) && isset($value['min_price']) && isset($value['max_price'])) {

            return $builder->whereBetween('price', [$value['min_price'], $value['max_price']]);
        }

        //dd($builder->toSql(), $builder->getBindings());

        return $builder;
    }
}
