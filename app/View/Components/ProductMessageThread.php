<?php

namespace App\View\Components;

use App\Http\Controllers\MessageController;
use App\Models\Message;
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
    /**
     * Create a new component instance.
     */
    public function __construct(public Product $product, public bool $isActive)
    {
        $this->soldBy = $product->soldBy()->get()->first();
        $this->latestMessage = MessageController::getMessages(Auth::user(), $product)->first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-message-thread', ['soldBy' => $this->soldBy, 'latestMessage' => $this-> latestMessage, 'product' => $this->product, 'isActive' => $this->isActive]);
    }
}
