<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();

        return view('pages.checkout', ['cart' => $cart]);
    }
}
