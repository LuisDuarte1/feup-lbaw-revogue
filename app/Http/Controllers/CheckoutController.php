<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function getPage(Request $request)
    {
        $user = $request->user();
        $cart = $user->cart()->get();

        return view('pages.checkout', ['cart' => $cart]);
    }

    public function postPage(Request $request)
    {
        //dd($request);
        $request->validate([
            'full_name' => 'required|max:250',
            'email' => 'required|email:rfc',
            'address' => 'required|max:500',
            'country' => 'required',
            'zip_code' => 'required|max:1000',
            'phone' => 'required|integer',
            'payment_method' => 'required',
        ]);

        DB::beginTransaction();
        $cart = $request->user()->cart()->get();
        $cartGrouped = $cart->groupBy('sold_by');
        if ($request->payment_method === '0') {
            $purchase = Purchase::create(['method' => 'delivery']);
            foreach($cartGrouped as $soldBy => $products){
                $order = $request->user()->orders()->create([
                    'status' => 'pendingShipment', //payment at delivery goes straight to pendingShipment
                    'shipping_address' => [
                        'name' => $request->full_name,
                        'email' => $request->email,
                        'country' => $request->country,
                        'address' => $request->address,
                        'zip-code' => $request->zip_code,
                        'phone' => $request->phone,
                    ],
                    'purchase' => $purchase->id
                ]);
    
                $ids = [];
                foreach ($products as $product) {
                    array_push($ids, $product->id);
                }
                $order->products()->attach($ids);
            }
        }
        // remove the cart of all users because it has been bought
        // TODO(luisd): send notification
        foreach ($cart as $product) {
            $product->inCart()->detach();
            $product->wishlist()->detach();
        }
        DB::commit();

        return redirect('/');
    }
}
