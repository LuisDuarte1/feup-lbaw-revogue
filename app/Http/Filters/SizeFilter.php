<?php

// SizeFilter.php

namespace App\Filters;

use App\Models\Product;
use Illuminate\Http\Request;

class SizeFilter
{
    public function index_product(Request $request)
    {
        $query = Product::orderBy('created_at', 'desc');
        if ($request->size) {
            $query = $query->where('size', $request->size);
        }
        $products = $query->paginate(5);

        return view('frontend.shop', compact('products'));
    }
}
