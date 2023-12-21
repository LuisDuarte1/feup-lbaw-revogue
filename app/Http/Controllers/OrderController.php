<?php

namespace App\Http\Controllers;

use App\Events\ProductMessageEvent;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderCancellation;
use App\Models\User;
use App\View\Components\MessageBubble;
use App\View\Components\SystemMessages\OrderChangedState;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public static function getActiveOrderCancellations(Order $order)
    {
        return $order->orderCancellations()->where('order_cancellation_status', 'pending')->get();
    }

    public function getOrderStatusAPI(Request $request)
    {
        $orderId = $request->route('id');

        $order = Order::find($orderId);

        if ($order === null) {
            return response()->json(['error' => "Couldn't find order by it's id."], 404);
        }

        $user = $request->user();

        $found = false;
        if ($order->belongs_to === $user->id) {
            $found = true;
        }
        if ($order->products[0]->sold_by === $user->id) {
            $found = true;
        }

        if (! $found) {
            return response()->json(['error' => "This order doesn't belong to you."], 403);
        }

        return response()->json(['status' => $order->status]);
    }

    public function changeOrderStatus(Request $request)
    {
        $orderId = $request->route('id');
        $order = Order::find($orderId);

        if ($order === null) {
            return response()->json(['error' => "Couldn't find order by it's id."], 404);
        }

        $user = $request->user();

        $found = false;
        $isSeller = false;
        if ($order->belongs_to === $user->id) {
            $found = true;
        }
        if ($order->products[0]->sold_by === $user->id) {
            $found = true;
            $isSeller = true;
        }

        if (! $found) {
            return response()->json(['error' => "This order doesn't belong to you."], 403);
        }

        if (OrderController::getActiveOrderCancellations($order)->count() > 0) {
            return response()->json(['error' => 'This order has a pending cancellation request.'], 400);
        }

        $request->validate([
            'new_status' => 'required',
        ]);

        //TODO: send notification and send message to order channel
        if ($order->status === 'pendingShipment' && $request->new_status === 'shipped' && $isSeller) {
            $oldState = $order->status;
            $order->status = $request->new_status;
            $order->save();
            $component = (new OrderChangedState($request->user(), $oldState, $order->status))->render();
            MessageController::sendSystemMessage($order->messageThread, $component->render(), null);

            return response()->json([]);
        }

        if ($order->status === 'shipped' && $request->new_status === 'received' && ! $isSeller) {
            $oldState = $order->status;
            $order->status = $request->new_status;
            $order->save();
            $component = (new OrderChangedState($request->user(), $oldState, $order->status))->render();
            MessageController::sendSystemMessage($order->messageThread, $component->render(), null);

            return response()->json([]);
        }

        return response()->json(['error' => "Cannot chanche order state, because you invoked a invalid state or you don't have permissions to do so."], 400);
    }

    public function getPossibleStatusChangeAPI(Request $request)
    {
        $orderId = $request->route('id');
        $order = Order::find($orderId);

        if ($order === null) {
            return response()->json(['error' => "Couldn't find order by it's id."], 404);
        }

        $user = $request->user();

        $found = false;
        $isSeller = false;
        if ($order->belongs_to === $user->id) {
            $found = true;
        }
        if ($order->products[0]->sold_by === $user->id) {
            $found = true;
            $isSeller = true;
        }

        if (! $found) {
            return response()->json(['error' => "This order doesn't belong to you."], 403);
        }

        $possibleStatus = null;
        if ($order->status === 'pendingShipment' && $isSeller) {
            $possibleStatus = 'shipped';
        }
        if ($order->status === 'shipped' && ! $isSeller) {
            $possibleStatus = 'received';
        }

        return response()->json(['statusChange' => $possibleStatus], 200);
    }

    public static function updateOrderCancellationStatus(Request $request, OrderCancellation $orderCancellation, $newStatus)
    {
        $messageThread = $orderCancellation->messages[0]->messageThread;
        $otherUser = null;
        if ($messageThread->user_1 === $request->user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        if (! ($request->user()->id === $messageThread->user_1 || $request->user()->id === $messageThread->user_2)) {
            return response()->json(['error' => 'Only the seller or the recipient can reject a bargain'], 403);
        }

        if ($orderCancellation->order_cancellation_status !== 'pending') {
            return response()->json(['error' => 'You can only make one action to a cancellation'], 400);
        }

        if ($newStatus === 'accepted') {
            $order = $orderCancellation->getOrder;
            $order->status = 'cancelled';
            $order->save();
        }
        $orderCancellation->order_cancellation_status = $newStatus;
        $orderCancellation->update();

        $message = Message::create([
            'message_type' => 'cancellation',
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'message_thread' => $messageThread->id,
            'order_cancellation' => $orderCancellation->id,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();
    }

    public function acceptOrderCancellation(Request $request)
    {
        $orderCancellationId = $request->route('id');

        $orderCancellation = OrderCancellation::find($orderCancellationId);

        if ($orderCancellation === null) {
            return response()->json(['error' => "Couldn't find cancellation order"], 404);
        }

        return OrderController::updateOrderCancellationStatus($request, $orderCancellation, 'accepted');

    }

    public function rejectOrderCancellation(Request $request)
    {
        $orderCancellationId = $request->route('id');

        $orderCancellation = OrderCancellation::find($orderCancellationId);

        if ($orderCancellation === null) {
            return response()->json(['error' => "Couldn't find cancellation order"], 404);
        }

        return OrderController::updateOrderCancellationStatus($request, $orderCancellation, 'cancelled');

    }
}
