<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use App\View\Components\MessageBubble;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductMessageEvent implements ShouldBroadcast
{
    use SerializesModels, InteractsWithSockets;

    /**
     * Create a new event instance.
     */
    public function __construct(private User $toUser, private Message $message)
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('messagethreads.'.$this->message->message_thread),
        ];
    }

    public function broadcastWith(): array
    {   
        $messageBubble = new MessageBubble($this->message, $this->toUser);
        $content = $messageBubble->render();
        return ['content' => $content->render()]; 
    }
}
