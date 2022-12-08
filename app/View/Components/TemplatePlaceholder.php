<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TemplatePlaceholder extends Component
{
    public function __construct()
    {
        //
    }

    public function render()
    {
        return view('components.template-placeholder');
    }
}
