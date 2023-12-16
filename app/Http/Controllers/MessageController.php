<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use App\View\Components\MessageBubble;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public static function getMessages(User $user, Product $product, $perPage=10){
        return Message::where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);
        })->where('subject_product', $product->id)->orderBy('sent_date', 'DESC')->paginate($perPage);
    }

    public static function getMessageThreads(User $user): \Illuminate\Support\Collection{
        return Message::select('subject_product')->where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);})->latest()->get()->pluck('subject_product')->unique()->values();
    }

    public function getPage(Request $request){
        $messageThreads = MessageController::getMessageThreads($request->user())->map(function ($product_id) {
            return Product::where('id', $product_id)->get()->first();
        });
        $productId = $request->query('product');
        $product = null;
        if(!isset($productId)){
            $product = $messageThreads[0];
        } else {
            $product = Product::where('id', $productId)->get()->first();

        }
        $messages = [];
        if($product !== null){
            $messages = MessageController::getMessages($request->user(), $product);
        }

        
        return view('pages.messages', ['messageThreads' => $messageThreads, 'messages' => $messages, 'product' => $product, 'currentUser' => $request->user()]);
    }

    public function sendMessageAPI(Request $request){
        $productId = $request->route('id');
        $product = Product::where('id', $productId)->get()->first();
        if($product === null){
            return response()->json(['error' => 'product does not exist'], 404);
        }

        //TODO: add image and make check for text and image
        $request->validate([
            'text' => 'nullable|max:10000'
        ]);
        $message = $request->user()->messagesFrom()->create([
            'message_type' => 'text',
            'text_content' => $request->text,
            'to_user' => $product->sold_by,
            'subject_product' => $product->id,
            'image_path' => []
        ]);
        $messageBubble = new MessageBubble($message, $request->user());
        return $messageBubble->render();
    }
}
