<?php

namespace App\View\Components;

use Illuminate\View\Component;

class EyeIcon extends Component
{
    public $id;
    public $class;
    public $fieldId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($fieldId, $id = '', $class = 'h-5 w-5')
    {
        $this->fieldId = $fieldId;
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.eye-icon');
    }
}
