<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Submenu extends Component
{
    public function __construct(
        private string $route,
        private array $routeParams = []
    )
    {
        //
    }

    public function render()
    {
        return view('components.submenu', [
            'route' => $this->route,
            'routeParams' => $this->routeParams,
        ]);
    }
}
