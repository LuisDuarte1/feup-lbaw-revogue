<?php

// TypeFilter.php

namespace App\Filters;

use App\Models\Product;
use Illuminate\Http\Request;

class PriceFilter
{
    public function priceIndexProduct(Request $request)
    {
        $query = Product::orderBy('price', 'asc');
        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }
        $products = $query->paginate(20);

        return view('products.index', compact('products'));
    }
}
