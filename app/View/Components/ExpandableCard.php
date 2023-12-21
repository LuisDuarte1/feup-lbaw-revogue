<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ExpandableCard extends Component
{
    public $question;

    public $answer;

    public function __construct($question, $answer)
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function render(): View|Closure|string
    {
        return view('components.expandable-card', [
            'question' => $this->question,
            'answer' => $this->answer,
        ]);
    }
}
