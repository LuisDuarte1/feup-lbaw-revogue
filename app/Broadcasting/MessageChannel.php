<?php

namespace App\Broadcasting;

use App\Models\Message;
use App\Models\MessageThread;
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
    public function join(User $user, int $messageThreadId): array|bool
    {
        $messageThread = MessageThread::where('id', $messageThreadId)->get()->first();
        
        if($messageThread === null){
            return false;
        }

        if($messageThread->user_1 == $user->id) return true;
        if($messageThread->user_2 == $user->id) return true;

        return false;
    }
}
