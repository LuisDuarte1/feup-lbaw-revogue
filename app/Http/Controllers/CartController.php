<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public static function getCartPrice(Request $request): float
    {
        $user = $request->user();
        $appliedVouchers = VoucherController::getAppliedVouchers($request);
        $price = 0.0;

        foreach ($user->cart()->get() as $product) {
            $voucher = $appliedVouchers->filter(function ($value, $key) use ($product) {
                return $value->product === $product->id;
            })->first();
            if ($voucher !== null) {
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

        $applyVoucher = $request->query('voucher');

        $errors = collect([]);

        if ($applyVoucher !== null) {

            $voucher = Voucher::where('code', $applyVoucher)->get()->first();

            if ($voucher === null) {
                $errors->put('voucher_does_not_exist', 'Voucher code does not exist.');
            }

            if ($voucher->belongs_to !== $request->user()->id) {
                $errors->put('voucher_not_owned', 'This voucher does not belong to you.');
            }

            if ($voucher->used) {
                $errors->put('voucher_used', 'This voucher has already been used.');
            }
            if ($errors->isEmpty()) {
                if ($user->cart()->get()->filter(function ($value, $key) use ($voucher) {
                    return $value->id == $voucher->product;
                })->isEmpty()) {
                    $user->cart()->attach($voucher->product);
                }

                $appliedVouchers->push($voucher);
                $appliedVouchers = $appliedVouchers->unique('code');
                $cart = $user->cart()->get()->groupBy('sold_by');

                VoucherController::setAppliedVouchers($request, $appliedVouchers);
            }
        }

        return view('pages.cart', ['cart' => $cart, 'appliedVouchers' => $appliedVouchers, 'cartPrice' => CartController::getCartPrice($request)])->with('errors', $errors);
    }

    public function count(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();

        return response()->json(['count' => count($cart)]);
    }
}
