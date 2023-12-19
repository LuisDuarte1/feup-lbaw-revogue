<?php

namespace App\View\Components;

use App\Http\Controllers\MessageController;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class ProductMessageThread extends Component
{
    public User $soldBy;

    public Message $latestMessage;

    public Product $product;

    /**
     * Create a new component instance.
     */
    public function __construct(public MessageThread $messageThread, public bool $isActive)
    {
        $this->product = $messageThread->messageProduct()->get()->first();
        $this->soldBy = $this->product->soldBy()->get()->first();
        $this->latestMessage = MessageController::getMessages(Auth::user(), $messageThread)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-message-thread', ['soldBy' => $this->soldBy, 'latestMessage' => $this->latestMessage, 'messageThread' => $this->messageThread, 'isActive' => $this->isActive, 'product' => $this->product]);
    }
}
