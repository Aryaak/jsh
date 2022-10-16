<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormCheck extends Component
{
    public function __construct(
        private string $id,
        private string $name,
        private string $value = '',
        private string $type = 'checkbox',
        private bool $checked = false,
        private bool $disabled = false,
        private bool $required = false,
        private bool $inline = false,
    ) {
        //
    }

    public function render()
    {
        return view('components.form-check', [
            'id' => $this->id,
            'name' => $this->name,
            'value' => $this->value,
            'type' => $this->type,
            'checked' => $this->checked,
            'disabled' => $this->disabled,
            'required' => $this->required,
            'inline' => $this->inline,
        ]);
    }
}
