<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Submit extends Component
{

    public $text;
    public $classes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $classes = '')
    {
        $this->text = $text;
        $this->classes = $classes;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.submit');
    }
}
