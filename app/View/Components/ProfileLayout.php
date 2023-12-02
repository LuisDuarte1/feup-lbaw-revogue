<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProfileLayout extends Component
{
    public $profilePicture;

    public $name;

    public $username;

    public $bio;

    public $rating;

    public function __construct($profilePicture, $name, $username, $bio, $rating)
    {
        $this->profilePicture = $profilePicture;
        $this->name = $name;
        $this->username = $username;
        $this->bio = $bio;
        $this->rating = $rating;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profileLayout', [
            'profilePicture' => $this->profilePicture,
            'name' => $this->name,
            'username' => $this->username,
            'bio' => $this->bio,
            'rating' => $this->rating,
        ]);
    }
}
