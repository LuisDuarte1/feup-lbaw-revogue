<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileNavbar extends Component
{
    /**
     * Create a new component instance.
     */
    public string $tab;

    public bool $ownPage;

    public string $id;

    public function __construct($tab, $ownPage, $id)
    {
        $this->tab = $tab;
        $this->ownPage = $ownPage;
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile-navbar', ['tab' => $this->tab, 'ownPage' => $this->ownPage, 'id' => $this->id]);
    }
}
