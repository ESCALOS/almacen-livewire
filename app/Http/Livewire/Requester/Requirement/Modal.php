<?php

namespace App\Http\Livewire\Requester\Requirement;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $products = [
        'id' => '',
        'quantity' => ''
    ];
    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric'
        ];
    }

    public function messages(){
        return [
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
        ];
    }

    public function openModal(){
        $this->resetExcept('open');
        $this->open = true;
    }

    public function addProduct(){
        $this->products[] = [
            'id' => '',
            'quantity' => ''
        ];
    }

    public function removeProduct($index){
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function render()
    {
        return view('livewire.requester.requirement.modal');
    }
}
