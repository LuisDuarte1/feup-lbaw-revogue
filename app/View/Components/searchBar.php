<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class SearchBar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Auth::user();
        $cartCount = 0;

        if ($user != null) {
            $cartCount = $user->cart()->count();
        }

        return view('components.searchBar', ['cartCount' => $cartCount]);
    }
}
