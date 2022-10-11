<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Card extends Component
{
    public function __construct(
        public ?string $header = null,
        public ?string $headerAction = null
    )
    {
        //
    }

    public function render()
    {
        return view('components.card', [
            'header' => $this->header,
            'headerAction' => $this->headerAction,
        ]);
    }
}
