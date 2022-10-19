<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormTextarea extends Component
{
    public function __construct(
        private string $id,
        private string $name,
        private ?string $subLabel = null,
        private ?string $label = null,
        private ?string $labelBadge = null,
        private ?string $placeholder = null,
        private ?string $required = null,
        private ?string $readonly = null,
        private ?string $disabled = null,
        private ?string $autofocus = null,
        private bool $tinymce = false,
    ) {
        //
    }

    public function render()
    {
        return view('components.form-textarea', [
            'id' => $this->id,
            'name' => $this->name,
            'subLabel' => $this->subLabel,
            'label' => $this->label,
            'labelBadge' => $this->labelBadge,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'readonly' => $this->readonly,
            'disabled' => $this->disabled,
            'autofocus' => $this->autofocus,
            'tinymce' => $this->tinymce,
        ]);
    }
}
