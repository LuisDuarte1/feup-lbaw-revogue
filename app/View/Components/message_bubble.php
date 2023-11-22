<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class message_bubble extends Component
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
        return view('components.message_bubble',[
            'sender'=>$this->sender,
            'message'=>$this->message,
            'time'=>$this->time]);
    }
}
