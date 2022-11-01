<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HistoryItem extends Component
{
    public function __construct(
        private string $icon,
        private string $face = 'primary',
        private ?string $time = null,
    )
    {
        //
    }

    public function render()
    {
        return view('components.history-item', [
            'icon' => $this->icon,
            'face' => $this->face,
            'time' => $this->time,
        ]);
    }
}
