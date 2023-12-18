<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get()->groupBy('sold_by');

        return view('pages.cart', ['cart' => $cart]);
    }

    public function count(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();

        return response()->json(['count' => count($cart)]);
    }
}
