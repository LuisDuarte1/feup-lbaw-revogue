<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class expandableCard extends Component
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
