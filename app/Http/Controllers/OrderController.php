<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function getOrderStatusAPI(Request $request){
        $orderId = $request->route('id');

        $order = Order::find($orderId);

        if($order === null){
            return response()->json(["error" => "Couldn't find order by it's id."],404);
        }

        $user = $request->user();

        $found = false;
        if($order->belongs_to === $user->id){
            $found = true;
        }
        if($order->products[0]->sold_by === $user->id){
            $found = true;
        }

        if(!$found){
            return request()->json(["error" => "This order doesn't belong to you."], 403);
        }

        return response()->json(['status' => $order->status]);
    }


    function changeOrderStatus(Request $request){
        $orderId = $request->route('id');
        $order = Order::find($orderId);

        if($order === null){
            return response()->json(["error" => "Couldn't find order by it's id."],404);
        }

        $user = $request->user();

        $found = false;
        $isSeller = false;
        if($order->belongs_to === $user->id){
            $found = true;
        }
        if($order->products[0]->sold_by === $user->id){
            $found = true;
            $isSeller = true;
        }

        if(!$found){
            return request()->json(["error" => "This order doesn't belong to you."], 403);
        }

        $request->validate([
            'new_status' => 'required'
        ]);

        //TODO: send notification and send message to order channel
        if($order->status === 'pendingShipment' && $request->new_status === 'shipped' && $isSeller){
            $order->status = $request->new_status;
            $order->save();
            return response()->json([]);
        }

        if($order->status === 'shipped' && $request->new_status === 'received' && !$isSeller){
            $order->status = $request->new_status;
            $order->save();
            return response()->json([]);
        }

        return response()->json(["error" => "Cannot chanche order state, because you invoked a invalid state or you don't have permissions to do so."], 400);
    }

    function getPossibleStatusChangeAPI(Request $request){
        $orderId = $request->route('id');
        $order = Order::find($orderId);

        if($order === null){
            return response()->json(["error" => "Couldn't find order by it's id."],404);
        }

        $user = $request->user();

        $found = false;
        $isSeller = false;
        if($order->belongs_to === $user->id){
            $found = true;
        }
        if($order->products[0]->sold_by === $user->id){
            $found = true;
            $isSeller = true;
        }

        if(!$found){
            return response()->json(["error" => "This order doesn't belong to you."], 403);
        }

        $possibleStatus = null;
        if ( $order->status === 'pendingShipment' && $isSeller ){
            $possibleStatus = 'shipped';
        }
        if($order->status === 'shipped' && !$isSeller){
            $possibleStatus = 'received';
        }
        return response()->json(["statusChange" => $possibleStatus], 200);
    }
}
