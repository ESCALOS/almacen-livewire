<?php

namespace App\Http\Livewire\Logistic\Requirement;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $products = [
        [
            'id' => '',
            'quantity' => '',
            'price' => ''
        ]
    ];

    protected $listeners = ['openModal','getProducts'];

    public function openModal(){
        $this->open = true;
    }

    public function getProducts($products){
        $this->products = $products;
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.logistic.requirement.modal');
    }
}
