<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Menu extends Component
{
    public function __construct(
        private string $route,
        private string $icon,
        private ?string $submenus = null,
    )
    {
        //
    }

    public function render()
    {
        $activeRoute = $this->route;

        if (Str::contains($activeRoute, '.index')) {
            $activeRoute = Str::remove('.index', $activeRoute).'.*';
        }

        return view('components.menu', [
            'activeRoute' => $activeRoute,
            'route' => $this->route,
            'icon' => $this->icon,
            'submenus' => $this->submenus,
        ]);
    }
}
