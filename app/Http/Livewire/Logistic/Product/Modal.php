<?php

namespace App\Http\Livewire\Logistic\Product;

use Livewire\Component;

class Modal extends Component
{
    public $open;

    protected $listeners = ['OpenModal'];

    public function mount(){
        $this->open = false;
    }

    public function OpenModal() {
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.logistic.product.modal');
    }
}
