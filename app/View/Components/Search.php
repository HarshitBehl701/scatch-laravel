<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    /**
     * Create a new component instance.
     */
    public  $mdScreen;
    public  $elemIndex;
    public function __construct($mdScreen,$elemIndex)
    {
        $this->mdScreen =  $mdScreen;
        $this->elemIndex =  $elemIndex;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search');
    }
}
