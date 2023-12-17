<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PurchaseCard extends Component
{
    public $purchase;

    public $orders;

    public function __construct($purchase, $orders)
    {
        $this->purchase = $purchase;
        $this->orders = $orders;
    }

    public function render(): View|Closure|string
    {
        return view('components.purchaseCard', [
            'purchase' => $this->purchase,
            'orders' => $this->orders,
        ]);
    }
}
