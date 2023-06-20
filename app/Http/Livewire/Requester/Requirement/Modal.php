<?php

namespace App\Http\Livewire\Requester\Requirement;

use App\Models\Requirement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $products = [
        [
            'id' => '',
            'quantity' => ''
        ]
    ];
    protected $listeners = ['openModal','getProducts'];

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

    public function getProducts($products){
        $this->products = $products;
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

    public function save(){
        $this->validate();
        DB::transaction(function(){
            foreach ($this->products as $product) {
                Requirement::updateOrCreate(
                    [
                        'user_id' => Auth::user()->id,
                        'product_id' => $product['id'],
                        'met' => false
                    ],
                    [
                        'quantity' => $product['quantity']
                    ]
                );
            }
        });
        $this->emit('refreshDatatable');
        $this->alert('success','Productos Solicitados');
        $this->reset('open','products');
    }

    public function render()
    {
        return view('livewire.requester.requirement.modal');
    }
}
