<?php

namespace App\Http\Livewire\Logistic\Product;

use Livewire\Component;

class Base extends Component
{
    public function openModal(){
        $this->emitTo('logistic.product.modal','openModal',0);
    }

    public function render()
    {
        return view('livewire.logistic.product.base');
    }
}
