<?php

namespace App\View\Components;

use App\Models\Product;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class wishlistButton extends Component
{
    public Product $product;

    public bool $inwishlist;

    public function __construct(Product $product, bool $inwishlist)
    {
        $this->product = $product;
        $this->inwishlist = $inwishlist;
    }

    public function render(): View|Closure|string
    {
        return view('components.wishlist-button', [
            'product' => $this->product,
            'inwishlist' => $this->inwishlist,
        ]);
    }
}
