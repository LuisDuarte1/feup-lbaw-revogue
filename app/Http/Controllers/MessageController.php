<?php

namespace App\Http\Controllers;

use App\Events\ProductMessageEvent;
use App\Models\Bargain;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Product;
use App\Models\User;
use App\View\Components\MessageBubble;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public static function sendSystemMessage(MessageThread $messageThread, string $content, ?User $to_user): Message
    {
        $message = $messageThread->messages()->create([
            'message_type' => 'system',
            'system_message' => $content,
            'from_user' => null,
            'to_user' => isset($to_user) ? $to_user->id : null,
        ]);
        if ($to_user === null) {
            broadcast(new ProductMessageEvent(null, $message, true));
        }

        return $message;
    }

    public static function getMessages(User $user, MessageThread $messageThread, $perPage = 10)
    {
        return Message::where('message_thread', $messageThread->id)->where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id)->orWhere(function ($query) {
                $query->where('from_user', null)->where('to_user', null);
            });
        })->orderBy('sent_date', 'DESC')->paginate($perPage);
    }

    public static function getMessageThreads(User $user, $type): \Illuminate\Support\Collection
    {
        //TODO: make this accept product and order threads
        return MessageThread::where(function ($query) use ($user) {
            $query->where('user_1', $user->id)->orWhere('user_2', $user->id);
        })->where('type', $type)->orderBy('last_updated', 'DESC')->get();
    }

    public function getMessagesAPI(Request $request)
    {
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if ($messageThread === null) {
            return response()->json(['error' => 'cannot find thread id'], 404);
        }
        //TODO (luisd): check if it can see message thread with policy

        $messages = MessageController::getMessages($request->user(), $messageThread);

        return view('api.messageList', ['messages' => $messages, 'currentUser' => $request->user()]);
    }

    public function getPage(Request $request)
    {
        $messageThreadType = $request->query('type', 'product');
        $messageThreads = MessageController::getMessageThreads($request->user(), $messageThreadType);
        $threadId = $request->query('thread');
        $messageThread = null;

        if (! isset($threadId) && ! $messageThreads->isEmpty()) {
            $messageThread = $messageThreads[0];
        } else {
            $messageThread = MessageThread::find($threadId);
            if (isset($messageThread) && $messageThread->type !== $messageThreadType) {
                $messageThreads = MessageController::getMessageThreads($request->user(), $messageThread->type);
                $messageThreadType = $messageThread->type;
            }
        }

        $messages = [];
        if ($messageThread !== null) {
            $messages = MessageController::getMessages($request->user(), $messageThread);
        }

        return view('pages.messages', ['messageThreads' => $messageThreads, 'messages' => $messages, 'currentThread' => $messageThread, 'currentUser' => $request->user(), 'messageThreadType' => $messageThreadType]);
    }

    public function acceptBargainAPI(Request $request)
    {
        $bargainId = $request->route('id');
        $bargain = Bargain::where('id', $bargainId)->get()->first();
        if ($bargain === null) {
            return response()->json(['error' => 'Bargain does not exist'], 404);
        }
        if ($request->user()->id !== $bargain->getProduct->sold_by) {
            return response()->json(['error' => 'Only the seller can accept a bargain'], 403);
        }

        $messageThread = $bargain->messages[0]->messageThread;
        $otherUser = null;
        if ($messageThread->user_1 === $request->user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        if ($bargain->bargain_status !== 'pending') {
            return response()->json(['error' => 'You can only make one action to a bargain'], 400);
        }

        $bargain->bargain_status = 'accepted';
        $bargain->update();

        $voucher = $bargain->voucher()->create([
            'code' => Str::random(10),
            'belongs_to' => $otherUser,
            'product' => $bargain->product,
        ]);

        $message = Message::create([
            'message_type' => 'bargain',
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'message_thread' => $messageThread->id,
            'bargain' => $bargain->id,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();
    }

    public function rejectBargainAPI(Request $request)
    {
        $bargainId = $request->route('id');
        $bargain = Bargain::where('id', $bargainId)->get()->first();
        if ($bargain === null) {
            return response()->json(['error' => 'Bargain does not exist'], 404);
        }

        $messageThread = $bargain->messages[0]->messageThread;
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

        if ($bargain->bargain_status !== 'pending') {
            return response()->json(['error' => 'You can only make one action to a bargain'], 400);
        }

        $bargain->bargain_status = 'rejected';
        $bargain->update();

        $message = Message::create([
            'message_type' => 'bargain',
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'message_thread' => $messageThread->id,
            'bargain' => $bargain->id,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();
    }

    public function sendBargainAPI(Request $request)
    {
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if ($messageThread === null) {
            return response()->json(['error' => 'Message thread does not exist'], 404);
        }
        $otherUser = null;
        if ($messageThread->user_1 === $request->user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        if (ProductController::isProductSold($messageThread->messageProduct()->get()->first())) {
            return response()->json(['error' => 'This product has already been sold'], 410);
        }

        $validated = $request->validate([
            'proposed_price' => 'required|numeric',
        ]);
        if ($request->user()->id === $messageThread->messageProduct->sold_by) {
            return response()->json(['error' => 'The seller cannot propose a bargain offer.'], 400);
        }

        if ($messageThread->messageProduct->price <= $validated['proposed_price']) {
            return response()->json(['error' => 'The proposed price cannot be higher than the current price'], 400);
        }

        if ($validated['proposed_price'] <= 0) {
            return response()->json(['error' => 'The proposed price must be higher than 0.'], 400);

        }

        $threadBargains = $messageThread->messages()->select('bargain')->where('message_type', 'bargain')->get()->pluck('bargain')->unique()->map(function ($item, $key) {
            return Bargain::where('id', $item)->get()->first();
        });

        $acceptedBargains = $threadBargains->filter(function ($item, $key) {
            return $item->bargain_status === 'accepted';
        });

        if ($acceptedBargains->count() > 0) {
            return response()->json(['error' => "Cannot create bargain while there's one accepted already."], 400);
        }

        $pendingBargains = $threadBargains->filter(function ($item, $key) {
            return $item->bargain_status === 'pending';
        });

        foreach ($pendingBargains as $bargain) {
            $bargain->bargain_status = 'cancelled';
            $bargain->save();
            //TODO: send message that request has been cancelled
        }
        $bargain = Bargain::create([
            'bargain_status' => 'pending',
            'proposed_price' => $validated['proposed_price'],
            'product' => $messageThread->product,
        ]);

        $message = Message::create([
            'message_type' => 'bargain',
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'message_thread' => $messageThread->id,
            'bargain' => $bargain->id,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();
    }

    public function sendCancellationRequestAPI(Request $request)
    {
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if ($messageThread === null) {
            return response()->json(['error' => 'Message thread does not exist'], 404);
        }
        if ($messageThread->type !== 'order') {
            return response()->json(['error' => 'Message thread is not of order type'], 400);
        }
        $otherUser = null;
        if ($messageThread->user_1 === $request->user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        $order = $messageThread->messageOrder;

        if ($order->status !== 'pendingShipment') {
            return response()->json(['error' => 'You cannot request a cancellation after the product has been shipped'], 400);
        }

        if (OrderController::getActiveOrderCancellations($order)->count() > 0) {
            return response()->json(['error' => "There's already a active cancellation request on this order."], 400);
        }

        $orderCancellation = $order->orderCancellations()->create([
            'order_cancellation_status' => 'pending',
        ]);

        $message = $messageThread->messages()->create([
            'message_type' => 'cancellation',
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'order_cancellation' => $orderCancellation->id,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();
    }

    public function sendMessageAPI(Request $request)
    {
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if ($messageThread === null) {
            return response()->json(['error' => 'Message thread does not exist'], 404);
        }
        $otherUser = null;
        if ($messageThread->user_1 === $request->user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        //TODO: add also image
        $request->validate([
            'text' => 'nullable|max:10000',
            'image' => 'nullable|image',
        ]);

        if ($request->input('text') === null && $request->file('image') === null) {
            return response()->json(['error' => 'Image and text cannot both be null'], 400);
        }

        $imagePath = null;
        if ($request->file('image') !== null) {
            $file = $request->file('image');
            $imagePath = '/storage/'.$file->storePublicly('message-images', ['disk' => 'public']);

        }

        $message = $messageThread->messages()->create([
            'message_type' => 'text',
            'text_content' => $request->input('text'),
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'image_path' => $imagePath,
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());

        return $messageBubble->render();

    }

    public function createMessageThread(Request $request)
    {
        $productId = $request->route('id');
        $product = Product::where('id', $productId)->get()->first();
        if ($product === null) {
            return back()->withErrors(['create-error' => 'Product does not exist']);
        }

        $request->validate([
            'text' => 'required|max:10000',
        ]);
        $user = $request->user();
        $messageThread = MessageThread::where(function ($query) use ($user) {
            $query->where('user_1', $user->id)->orWhere('user_2', $user->id);
        })
            ->where('product', $productId)->get()->first();

        if ($messageThread === null) {
            $messageThread = MessageThread::create([
                'type' => 'product',
                'user_1' => $request->user()->id,
                'user_2' => $product->sold_by,
                'product' => $product->id,
            ]);
        }

        $messageThread->messages()->create([
            'message_type' => 'text',
            'text_content' => $request->text,
            'to_user' => $product->sold_by,
            'from_user' => $request->user()->id,
            'image_path' => null,
        ]);

        return redirect('/messages?thread='.$messageThread->id);
    }
}
