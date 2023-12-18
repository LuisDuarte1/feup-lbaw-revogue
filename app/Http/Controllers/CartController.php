<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{

    public static function getCartPrice(Request $request): float{
        $user = $request->user();
        $appliedVouchers = VoucherController::getAppliedVouchers($request);
        $price = 0.0;

        foreach($user->cart()->get() as $product){
            $voucher = $appliedVouchers->filter(function ($value, $key) use ($product) {
                return $value->product === $product->id;
            })->first();
            if($voucher !== null){
                $price += $voucher->bargainMessage->proposed_price;
            } else {
                $price += $product->price;
            }

        }

        return $price;
    }

    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get()->groupBy('sold_by');
        $appliedVouchers = VoucherController::getAppliedVouchers($request);

        return view('pages.cart', ['cart' => $cart, 'appliedVouchers' => $appliedVouchers, 'cartPrice' => CartController::getCartPrice($request)]);
    }
}
