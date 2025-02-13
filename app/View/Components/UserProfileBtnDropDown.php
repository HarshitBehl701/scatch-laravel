<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfileBtnDropDown extends Component
{
    /**
     * Create a new component instance.
     */
    public  $componentId;
    public function __construct($componentId)
    {
        $this->componentId  =  $componentId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.user-profile-btn-drop-down');
    }
}
