<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public function __construct(
        private string $type = 'button',
        private string $face = 'primary',
        private string $size = 'md',
        private ?string $icon = null,
        private ?string $link = null,
    )
    {
        //
    }

    public function render()
    {
        return view('components.button', [
            'type' => $this->type,
            'face' => $this->face,
            'size' => $this->size,
            'icon' => $this->icon,
            'link' => $this->link,
        ]);
    }
}
