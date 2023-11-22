<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function getOrder(Request $request)
    {
    $orders = Order::}
    public function getPage(Request $request)
    {
        $orders = Order::paginate(20);
        return view('pages.admin.orders', ['orders' => $orders]);
    }
}
