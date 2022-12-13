<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Datatable extends Component
{
    public $id;
    public $route;
    public $searchable;
    public $nothing;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $route, $searchable = true, $nothing = false)
    {
        $this->id = $id;
        $this->route = $route;
        $this->searchable = $searchable;
        $this->nothing = $nothing;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.datatable');
    }
}
