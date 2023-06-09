<?php

namespace App\Http\Livewire\Logistic\OrderDate;

use Livewire\Component;
class Base extends Component
{
    public function openModal(){
        $this->emitTo('logistic.order-date.modal','openModal',0);
    }
    public function render()
    {
        return view('livewire.logistic.order-date.base');
    }
}
