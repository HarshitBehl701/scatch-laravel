<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductList extends Component
{
    /**
     * Create a new component instance.
     */

    public  $name;
    public  $description;
    public  $price;
    public  $images;

    public function __construct($name,$description,$price,$images)
    {
        $this->name =  $name;
        $this->description =  $description;
        $this->price =  $price;
        $this->images =  $images;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-list');
    }
}
