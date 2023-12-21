<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class FilterBar extends Component
{
    /**
     * Create a new component instance.
     */

    public function __construct(public Collection $filterAttributes)
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-bar', ['filterAttributes' => $this->filterAttributes]);
    }
}
