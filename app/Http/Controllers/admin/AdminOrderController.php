<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


class AdminOrderController extends Controller
{

    public function updateStatus(Request $request)
    {
        $order = Order::find($request->id);
        $order->status = $request->status;
        $order->save();
        return response()->json(['success' => 'Status changed successfully.']);
    }

    public function getPage(Request $request)
    {
        $orders = Order::paginate(20);
        return view('pages.admin.orders', ['orders' => $orders]);
    }
}
