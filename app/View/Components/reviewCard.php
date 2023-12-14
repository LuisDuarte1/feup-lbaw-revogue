<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reviewCard extends Component
{
    public $reviewer;

    public $reviewerRating;

    public $reviewDescription;

    public $reviewImagePaths;

    public $reviewDate;

    public function __construct($reviewer, $reviewerRating, $reviewDescription, $reviewImagePaths, $reviewDate)
    {
        $this->reviewer = $reviewer;
        $this->reviewerRating = $reviewerRating;
        $this->reviewDescription = $reviewDescription;
        $this->reviewImagePaths = $reviewImagePaths;
        $this->reviewDate = $reviewDate;
    }

    public function render(): View|Closure|string
    {
        return view('components.reviewCard', [
            'reviewer' => $this->reviewer,
            'reviewerRating' => $this->reviewerRating,
            'reviewDescription' => $this->reviewDescription,
            'reviewImagePaths' => $this->reviewImagePaths,
            'reviewDate' => $this->reviewDate,
        ]);
    }
}
