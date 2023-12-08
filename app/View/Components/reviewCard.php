<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class reviewCard extends Component
{
    public $reviewerName;

    public $reviewerUsername;

    public $reviewerPicture;

    public $reviewerRating;

    public $reviewDescription;

    public $reviewImagePaths;

    public $reviewDate;

    public function __construct($reviewerName, $reviewerUsername, $reviewerPicture, $reviewerRating, $reviewDescription, $reviewImagePaths, $reviewDate)
    {
        $this->reviewerName = $reviewerName;
        $this->reviewerUsername = $reviewerUsername;
        $this->reviewerPicture = $reviewerPicture;
        $this->reviewerRating = $reviewerRating;
        $this->reviewDescription = $reviewDescription;
        $this->reviewImagePaths = $reviewImagePaths;
        $this->reviewDate = $reviewDate;
    }

    public function render(): View|Closure|string
    {
        return view('components.reviewCard', [
            'reviewerName' => $this->reviewerName,
            'reviewerUsername' => $this->reviewerUsername,
            'reviewerPicture' => $this->reviewerPicture,
            'reviewerRating' => $this->reviewerRating,
            'reviewDescription' => $this->reviewDescription,
            'reviewImagePaths' => $this->reviewImagePaths,
            'reviewDate' => $this->reviewDate,
        ]);
    }
}
