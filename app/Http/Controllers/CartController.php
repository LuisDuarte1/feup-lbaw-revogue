<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();

        return view('pages.cart', ['cart' => $cart]);
    }
}
