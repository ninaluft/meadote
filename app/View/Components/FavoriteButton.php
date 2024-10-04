<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FavoriteButton extends Component
{
    public $petId;
    public $isFavorited;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($petId, $isFavorited)
    {
        $this->petId = $petId;
        $this->isFavorited = $isFavorited;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.favorite-button');
    }
}
