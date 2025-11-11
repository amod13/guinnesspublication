<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public $id, $name, $label, $value, $placeholder, $required, $editor;

    public function __construct(
        $name,
        $label,
        $value = '',
        $placeholder = '',
        $required = false,
        $id = null ,// 👈 Make ID optional
        $editor = false
    ) {
        $this->name = $name;
        $this->label = $label;
        $this->value = old($name, $value);
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->id = $id ?? $name; // 👈 fallback: id = name
        $this->editor = $editor;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.textarea');
    }
}
