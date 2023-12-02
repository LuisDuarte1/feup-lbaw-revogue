<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function updateStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->order_status;
        $order->save();

        return back()->with('order', 'User status changed successfully');
    }

    public function getPage(Request $request)
    {
        $orders = Order::orderBy('id', 'asc')->paginate(20);

        return view('pages.admin.orders', ['orders' => $orders]);
    }
}
