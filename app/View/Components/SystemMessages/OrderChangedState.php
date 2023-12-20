<?php

namespace App\View\Components\SystemMessages;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OrderChangedState extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public User $byUser, public string $fromState, public string $toState)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.system-messages.order-changed-state', ['byUser' => $this->byUser, 'fromState'=>$this->fromState, 'toState'=>$this->toState]);
    }
}
