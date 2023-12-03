<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MessageBubble extends Component
{
    public $sender;

    public $message;

    public $time;

    public function __construct($sender, $message, $time)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->time = $time;
    }

    public function render(): View|Closure|string
    {
        return view('components.messageBubble', [
            'sender' => $this->sender,
            'message' => $this->message,
            'time' => $this->time]);
    }
}
