<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        private string $face = 'primary',
        private bool $rounded = false,
        private bool $proporsional = false,
    ) {
        //
    }

    public function render()
    {
        return view('components.badge', [
            'face' => $this->face,
            'rounded' => $this->rounded,
            'proporsional' => $this->proporsional,
        ]);
    }
}
