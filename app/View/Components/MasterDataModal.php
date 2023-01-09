<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MasterDataModal extends Component
{
    public $id, $modalTitle, $path, $inputId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = "", $modalTitle = "", $path = "", $inputId = "")
    {
        $this->id = $id;
        $this->modalTitle = $modalTitle;
        $this->path = json_encode($path);
        $this->inputId = json_encode($inputId);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.master-data-modal');
    }
}
