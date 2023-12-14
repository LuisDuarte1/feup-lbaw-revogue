<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reviewCard extends Component
{
    public $review;

    public function __construct($review)
    {
        $this->review = $review;
    }

    public function render(): View|Closure|string
    {
        return view('components.reviewCard', [
            'review' => $this->review,
        ]);
    }
}
