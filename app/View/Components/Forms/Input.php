<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $placeholder;
    public $type;
    public $classes;
    public $mb;
    public $label;
    public $value;
    public $model;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name = '', $value = '', $placeholder = null, $label = '', $type = 'text', $classes = '', $mb = 'mb-8', $disabled = false, $model = null)
    {
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->type = $type;
        $this->classes = $classes;
        $this->mb = $mb;
        $this->label = $label;
        $this->value = $value;
        $this->disabled = $disabled;
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.input');
    }
}
