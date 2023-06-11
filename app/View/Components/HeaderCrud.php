<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HeaderCrud extends Component
{

    public $label;
    public $action;

    public function __construct($label='Registrar',$action='openModal')
    {
        $this->label = $label;
        $this->action = $action;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header-crud');
    }
}
