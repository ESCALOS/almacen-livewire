<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\Warehouse;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId;
    public $departmentId = 0;
    public $products = [
        [
            'id' => '',
            'name' => '',
            'price' => '',
        ]
    ];

    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'products.*.name' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

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
