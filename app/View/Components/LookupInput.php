<?php

namespace App\View\Components;

use App\Models\MenuList;
use Illuminate\View\Component;

class LookupInput extends Component
{
    public $label, $id, $placeholder, $name, $modalId, $lookupData;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = "", $id = "", $placeholder = "", $name = "", $modalId = "", $data = null)
    {
        $this->label = $label;
        $this->id = $id;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->modalId = $modalId;
        $this->lookupData = $data;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.lookup-input');
    }
}
