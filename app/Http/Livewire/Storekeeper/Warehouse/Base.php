<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use Livewire\Component;

class Base extends Component
{
    public function openModal(){
        $this->emitTo('storekeeper.warehouse.modal','openModal',0);
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.base');
    }
}
