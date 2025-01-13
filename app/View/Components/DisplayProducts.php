<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DisplayProducts extends Component
{
    /**
     * Create a new component instance.
     */

     public $productData;

    public function __construct($productData)
    {
        $this->productData  = $productData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.display-products');
    }
}
