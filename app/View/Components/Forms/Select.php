<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $placeholder;
    public $classes;
    public $mb;
    public $label;
    public $value;
    public $options;
    public $select2;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $options = [], $value = '', $placeholder = null, $label = '', $classes = '', $select2 = true, $mb = 'mb-8', $disabled = false)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->classes = $classes;
        $this->select2 = $select2;
        $this->mb = $mb;
        $this->label = $label;
        $this->value = $value;
        $this->options = $options;
        $this->disabled = $disabled;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
