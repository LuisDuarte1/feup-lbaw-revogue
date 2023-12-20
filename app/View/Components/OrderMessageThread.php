<?php

namespace App\View\Components;

use App\Http\Controllers\MessageController;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class OrderMessageThread extends Component
{
    public User $otherUser;

    public ?Message $latestMessage;

    /**
     * Create a new component instance.
     */
    public function __construct(public MessageThread $messageThread, public bool $isActive)
    {
        $otherUser = null;

        if ($messageThread->user_1 === Auth::user()->id) {
            $otherUser = $messageThread->user_2;
        } elseif ($messageThread->user_2 === Auth::user()->id) {
            $otherUser = $messageThread->user_1;
        }

        $this->otherUser = User::where('id', $otherUser)->get()->first();
        $this->latestMessage = MessageController::getMessages(Auth::user(), $messageThread)->first();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order-message-thread', ['soldBy' => $this->otherUser, 'latestMessage' => $this->latestMessage, 'messageThread' => $this->messageThread, 'isActive' => $this->isActive]);
    }
}
