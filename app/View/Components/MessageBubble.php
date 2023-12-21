<?php

namespace App\View\Components;

use App\Models\Message;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MessageBubble extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Message $message, public ?User $currentUser)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message-bubble', ['message' => $this->message, 'currentUser' => $this->currentUser]);
    }
}
