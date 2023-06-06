<?php

namespace App\Http\Livewire\Logistic\Product;

use Livewire\Component;

class Modal extends Component
{
    public $open;
    public $productId;
    public $name;
    public $description;
    public $measurementUnit;
    public $category;

    protected $listeners = ['openModal','putCategory'];

    public function mount(){
        $this->open = false;
        $this->productId = 0;
        $this->name = '';
        $this->description = '';
        $this->measurementUnit = '';
        $this->category = '';
    }

    public function openModal($id) {
        $this->productId = $id;
        $this->open = true;
    }

    public function putCategory($id) {
        $this->category = $id;
    }

    public function render()
    {
        return view('livewire.logistic.product.modal');
    }
}
