<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();
        
        $list = [];
        foreach($cart as $product){
            $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
            $color = $product->attributes()->where('key', 'Color')->get()->first()->value;
            array_push($list, ["product"=>$product, "size"=>$size, "color"=>$color]);
        }

        return view('pages.cart', ['cart' => $list]);
    }
}
