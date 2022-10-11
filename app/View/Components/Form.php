<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        private string $action = '',
        private string $method = 'get',
        private ?bool $sendFile = null,
        private ?string $submit = null,
        private ?string $submitFace = 'primary',
        private ?string $submitIcon = 'bx bxs-paper-plane',
        private ?bool $submitWide = null,
    )
    {
        //
    }

    public function render()
    {
        return view('components.form', [
            'action' => $this->action,
            'method' => $this->method,
            'sendFile' => $this->sendFile,
            'submit' => $this->submit,
            'submitFace' => $this->submitFace,
            'submitIcon' => $this->submitIcon,
            'submitWide' => $this->submitWide,
        ]);
    }
}
