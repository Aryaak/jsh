<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormLabel extends Component
{
    public function __construct(
        private ?string $for = null,
        private ?bool $required = null,
        private ?string $badge = null,
    )
    {
        //
    }

    public function render()
    {
        return view('components.form-label', [
            'for' => $this->for,
            'required' => $this->required,
            'badge' => $this->badge,
        ]);
    }
}
