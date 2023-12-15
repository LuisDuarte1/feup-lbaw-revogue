<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public static function getMessages(User $user, Product $product, $perPage=10){
        return Message::where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);
        })->where(function ($query) use ($product) {
            $query->where('from_user', $product->sold_by)->orWhere('to_user', $product->sold_by);
        })->orderBy('sent_date', 'DESC')->paginate($perPage);
    }

    public static function getMessageThreads(User $user): \Illuminate\Support\Collection{
        return Message::select('subject_product')->where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);
        })->distinct()->get()->pluck('subject_product');
    }

    public function getPage(Request $request){
        $messageThreads = MessageController::getMessageThreads($request->user())->map(function ($product_id) {
            return Product::where('id', $product_id)->get()->first();
        });
        $productId = $request->query('product');
        if(!isset($productId)){
            $productId = $messageThreads[0];
        }
        $messages = [];
        $product = null;
        if($productId !== null){
            $product = Product::where('id', $productId)->get()->first();
            $messages = MessageController::getMessages($request->user(), $product);
        }

        
        return view('pages.messages', ['messageThreads' => $messageThreads, 'messages' => $messages, 'product' => $product, 'currentUser' => $request->user()]);
    }
}
