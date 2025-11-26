<?php 

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class IconPicker extends Component
{
    public $id;
    public $name;
    public $label;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct(
        $id = 'icon',
        $name = 'icon',
        $label = 'Choose Icon',
        $value = ''
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.form.icon-picker');
    }
}
