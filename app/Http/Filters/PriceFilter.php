<?php

// TypeFilter.php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PriceFilter
{
    public function priceIndexProduct(Request $request, Builder $query)
    {

        if ($request->min_price && $request->max_price) {
            // ...

            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        return $query;

        //$products = $query->paginate(20);

        // return view('products.index', compact('products'))->render();
    }
}
