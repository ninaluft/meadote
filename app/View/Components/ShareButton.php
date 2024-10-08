<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ShareButton extends Component
{
    public $title;
    public $url;
    public $description;
    public $image;

    /**
     * Create a new component instance.
     *
     * @param string|null $title
     * @param string|null $url
     * @param string|null $description
     * @param string|null $image
     */
    public function __construct($title = null, $url = null, $description = null, $image = null)
    {
        $this->title = $title ?? 'Título padrão';
        $this->url = $url ?? url()->current();
        $this->description = $description ?? 'Descrição padrão';
        $this->image = $image ?? asset('default-image.png');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.share-button');
    }
}
