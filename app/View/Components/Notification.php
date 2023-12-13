<?php

namespace App\View\Components;

use App\Models\Notification as ModelsNotification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Notification extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $route, public ModelsNotification $notification)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification', ['route' => $this->route, 'notification' => $this->notification]);
    }
}
