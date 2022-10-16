<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        private string $id,
        private string $title,
        private ?string $size = null,
        private ?string $footer = null,
        private bool $darkBody = false,
    ) {
        //
    }

    public function render()
    {
        return view('components.modal', [
            'id' => $this->id,
            'title' => $this->title,
            'size' => $this->size,
            'footer' => $this->footer,
            'darkBody' => $this->darkBody,
        ]);
    }
}
