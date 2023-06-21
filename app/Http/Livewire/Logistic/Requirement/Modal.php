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
    public $paymentMethod;

    protected $listeners = ['openModal','getProducts'];

    public function updatedPaymentMethod(){
        if($this->paymentMethod){
            $this->alert('success','CONTADO');
        }else{
            $this->alert('success','CREDITO');
        }

    }

    public function rules(){
        return [
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
            'products.*.price' => 'El precio es requerido',
        ];
    }

    public function openModal(){
        $this->reset('products');
        $this->open = true;
    }

    public function getProducts($products){
        $this->products = $products;
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

    public function render()
    {
        return view('livewire.logistic.requirement.modal');
    }
}
