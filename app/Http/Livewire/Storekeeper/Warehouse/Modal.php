<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $departmentId = 0;
    public $products = [];

    protected $listeners = ['openModal'];
    protected $rules = [];

    public function openModal(){
        $this->resetExcept('open');
        $this->open = true;
    }

    public function addProduct(){
        $this->products[] = [
            'id' => '',
            'quantity' => '',
            'price' => '',
        ];
        $this->rules['products.*.name'] = 'required';
        $this->rules['products.*.quantity'] = 'required|numeric';
        $this->rules['products.*.price'] = 'required|numeric';
    }

    public function removeProduct($index){
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function save(){
        $this->validate();
        $this->alert('success','Productos ingresados');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal');
    }
}
