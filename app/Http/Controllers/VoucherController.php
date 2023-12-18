<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VoucherController extends Controller
{
    static function getAvailableVouchers(User $user){
        return $user->voucher()->get();
    }

    static function getAppliedVouchers(Request $request){
        return collect(array_map(function ($code) {
            return Voucher::where('code', $code)->get()->first();
        } , $request->session()->get("cartVouchers", [])));
    }

    static function setAppliedVouchers(Request $request, Collection $vouchers){
        $request->session()->put('cartVouchers', $vouchers->map(function ($value, $key) {
            return $value->code;
        })->toArray());
    }

    function applyVoucherAPI(Request $request){
        $voucherCode = $request->input('code');

        $voucher = Voucher::where('code', $voucherCode)->get()->first();

        if($voucher === null){
            return response()->json(["error" => "Voucher code does not exist."], 404);
        }

        if($voucher->belongs_to !== $request->user()->id){
            return response()->json(["error" => "This voucher does not belong to you."], 404);
        }

        if($voucher->used){
            return response()->json(["error" => "This voucher has already been used."], 400);
        }

        $cart = $request->user()->cart()->get();

        if($cart->filter(function ($value, $key) use ($voucher){
            return $value->id == $voucher->product;
        })->isEmpty()){
            return response()->json(["error" => "You must first add the product to the cart before applying the voucher", 400]);
        }

        $appliedVouchers = VoucherController::getAppliedVouchers($request);
        $appliedVouchers->push($voucher);

        VoucherController::setAppliedVouchers($request, $appliedVouchers->unique());

        return response()->json([], 200);

    }
}
