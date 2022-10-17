<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormInput extends Component
{
    public function __construct(
        private string $id,
        private string $name,
        private ?string $type = null,
        private ?string $label = null,
        private ?string $labelBadge = null,
        private ?string $value = null,
        private ?string $placeholder = null,
        private ?string $required = null,
        private ?string $readonly = null,
        private ?string $disabled = null,
        private ?string $autofocus = null,
        private ?string $prefix = null,
        private ?string $suffix = null,
        private ?string $classInput = null,
    )
    {
        //
    }

    public function render()
    {
        return view('components.form-input', [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'label' => $this->label,
            'labelBadge' => $this->labelBadge,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'readonly' => $this->readonly,
            'disabled' => $this->disabled,
            'autofocus' => $this->autofocus,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'classInput' => $this->classInput,
        ]);
    }
}
