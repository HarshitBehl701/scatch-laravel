<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Carousel extends Component
{
    /**
     * Create a new component instance.
     */
    public  $objArray;
    public  $navigation;

    public function __construct($objArray,$navigation)
    {
        $this->objArray   = $objArray;
        $this->navigation   = $navigation;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.carousel');
    }
}
