<?php

namespace App\View\Components\SystemMessages;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ShippingDetails extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public array $shippingDetails)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.system-messages.shipping-details', ['shippingDetails' => $this->shippingDetails]);
    }
}
