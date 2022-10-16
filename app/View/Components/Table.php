<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(
        private string $id = 'table',
        private ?string $thead = null,
        private ?string $tfoot = null,
    ) {
        //
    }

    public function render()
    {
        return view('components.table', [
            'id' => $this->id,
            'thead' => $this->thead,
            'tfoot' => $this->tfoot,
        ]);
    }
}
