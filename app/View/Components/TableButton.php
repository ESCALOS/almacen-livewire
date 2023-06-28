<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableButton extends Component
{
    public $id;
    public $icon;
    public $color;

    public function __construct($id=0,$icon="pencil",$color="primary")
    {
        $this->id = $id;
        $this->icon = $icon;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table-button');
    }
}
