<?php

namespace App\Http\Controllers;

use App\Events\ProductMessageEvent;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Product;
use App\Models\User;
use App\View\Components\MessageBubble;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public static function getMessages(User $user, MessageThread $messageThread, $perPage=10){
        return Message::where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);
        })->where('message_thread', $messageThread->id)->orderBy('sent_date', 'DESC')->paginate($perPage);
    }

    public static function getMessageThreads(User $user): \Illuminate\Support\Collection{
        //TODO: make this accept product and order threads
        return MessageThread::where(function ($query) use ($user) {
            $query->where('user_1', $user->id)->orWhere('user_2', $user->id);})->where('type', 'product')->orderBy('last_updated', 'DESC')->get();
    }

    public function getMessagesAPI(Request $request){
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if($messageThread === null){
            return response()->json(['error' => 'cannot find thread id'], 404);
        }
        //TODO (luisd): check if it can see message thread with policy

        $messages = MessageController::getMessages($request->user(), $messageThread);

        return view('api.messageList', ['messages' => $messages, 'currentUser'=>$request->user()]);
    }

    public function getPage(Request $request){
        $messageThreads = MessageController::getMessageThreads($request->user());
        $threadId = $request->query('thread');
        $messageThread = null;

        if(!isset($threadId) && !$messageThreads->isEmpty()){
            $messageThread = $messageThreads[0];
        } else {
            $messageThread = MessageThread::where('id', $threadId)->get()->first();
        }
        $messages = [];
        if($messageThread !== null){
            $messages = MessageController::getMessages($request->user(), $messageThread);
        }

        
        return view('pages.messages', ['messageThreads' => $messageThreads, 'messages' => $messages, 'currentThread' => $messageThread, 'currentUser' => $request->user()]);
    }

    public function sendMessageAPI(Request $request){
        $threadId = $request->route('id');
        $messageThread = MessageThread::where('id', $threadId)->get()->first();
        if($messageThread === null){
            return response()->json(['error' => 'Message thread does not exist'], 404);
        }
        $otherUser = null;
        if($messageThread->user_1 === $request->user()->id){
            $otherUser = $messageThread->user_2;
        } else if ($messageThread->user_2 === $request->user()->id) {
            $otherUser = $messageThread->user_1;
        } else {
            return response()->json(['error' => 'This message thread does not belong to you'], 403);
        }

        //TODO: add also image
        $request->validate([
            'text' => 'nullable|max:10000',
            'image' => 'nullable|image'
        ]);

        if($request->input('text') === null && $request->file('image') === null){
            return response()->json(['error' => 'Image and text cannot both be null'], 400);
        }

        $imagePath = null;
        if($request->file('image') !== null){
            $file = $request->file('image');
            $imagePath = '/storage/'.$file->storePublicly('message-images', ['disk' => 'public']);

        }

        $message = $messageThread->messages()->create([
            'message_type' => 'text',
            'text_content' => $request->input('text'),
            'to_user' => $otherUser,
            'from_user' => $request->user()->id,
            'image_path' => $imagePath
        ]);

        broadcast(new ProductMessageEvent(User::where('id', $otherUser)->get()->first(), $message))->toOthers();

        $messageBubble = new MessageBubble($message, $request->user());
        return $messageBubble->render();

    }

    public function createMessageThread(Request $request){
        $productId = $request->route('id');
        $product = Product::where('id', $productId)->get()->first();
        if($product === null){
            return back()->withErrors(['create-error' => 'Product does not exist']);
        }

        $request->validate([
            'text' => 'required|max:10000'
        ]);

        $messageThread = MessageThread::create([
            'type' => 'product',
            'user_1' => $request->user()->id,
            'user_2' => $product->sold_by,
            'product' => $product->id
        ]);

        $messageThread->messages()->create([
            'message_type' => 'text',
            'text_content' => $request->text,
            'to_user' => $product->sold_by,
            'from_user' => $request->user()->id,
            'image_path' => null
        ]);

        return redirect('/messages?thread='.$messageThread->id);
    }
}
