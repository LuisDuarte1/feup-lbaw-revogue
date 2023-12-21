<?php

namespace App\Http\Controllers;

class LandingPageController extends Controller
{
    public function getTrendingProducts()
    {
        $products = ProductController::getTrendingProducts()->slice(0, 15);
        $list = [];
        foreach ($products as $product) {
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ['product' => $product, 'size' => $size, 'color' => $color]);
        }

        return view('pages.landing', ['products' => $list]);
    }
}
