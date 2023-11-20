<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getPage(Request $request)
    {
        $product_id = $request->route('id');
        $product = Product::find($product_id);
        $attributes = $product->attributes()->get();
        return view('pages.product', ['product' => $product, 'attributes' => $attributes]);
    }
}
