<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormSelect extends Component
{
    public function __construct(
        private string $id,
        private string $name,
        private array $options = [],
        private string $selectedNone = '-- Pilih --',
        private ?string $label = null,
        private ?string $labelBadge = null,
        private ?string $helper = null,
        private ?string $value = null,
        private ?string $placeholder = null,
        private ?string $single = null,
        private ?string $empty = null,
        private ?string $required = null,
        private ?string $disabled = null,
        private ?string $readonly = null,
        private ?string $multiple = null,
        private ?string $autofocus = null,
        private ?string $classInput = null,
    ) {
        //
    }

    public function render()
    {
        return view('components.form-select', [
            'id' => $this->id,
            'name' => $this->name,
            'options' => $this->options,
            'label' => $this->label,
            'labelBadge' => $this->labelBadge,
            'helper' => $this->helper,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'selectedNone' => $this->selectedNone,
            'single' => $this->single,
            'empty' => $this->empty,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'readonly' => $this->readonly,
            'multiple' => $this->multiple,
            'classInput' => $this->classInput,
        ]);
    }
}
