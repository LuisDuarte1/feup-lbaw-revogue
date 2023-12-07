<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SettingsNavbar extends Component
{
    /**
     * Create a new component instance.
     */
    public string $tab;

    public string $id;

    public function __construct($tab, $id)
    {
        $this->tab = '$tab';
        $this->id = '$id';
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.settings-navbar');
    }
}
