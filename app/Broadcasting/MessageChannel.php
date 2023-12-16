<?php

namespace App\Broadcasting;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;

class MessageChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, int $productId, int $userId): array|bool
    {
        if($user->id !== $userId){
            return false;
        }
        //we check if there are existing messages to listen on
        return Message::where(function ($query) use ($user) {
            $query->where('from_user', $user->id)->orWhere('to_user', $user->id);
        })->where('subject_product', $productId)->count() > 0;
    }
}
