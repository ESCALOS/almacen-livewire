<?php

namespace App\Http\Livewire\Logistic\Warehouse;

use App\Models\WarehouseDetail;
use App\Models\WarehouseInput;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId = 0;
    public $products = [
        [
            'id' => '',
            'quantity' => '',
            'price' => '',
        ]
    ];

    protected $listeners = ['openModal'];

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

    public function openModal($warehouseId){
        $this->resetExcept('open');
        $this->warehouseId = $warehouseId;
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
        DB::transaction(function(){
            foreach ($this->products as $product) {
                $warehouseDetail = WarehouseDetail::firstOrCreate([
                    'warehouse_id' => $this->warehouseId,
                    'product_id' => $product['id']
                ]);

                $warehouseInput = new WarehouseInput();
                $warehouseInput->warehouse_detail_id = $warehouseDetail->id;
                $warehouseInput->quantity = $product['quantity'];
                $warehouseInput->price = $product['price'];
                $warehouseInput->save();

                $warehouseDetail->quantity = $warehouseDetail->quantity + $product['quantity'];
                $warehouseDetail->price = $warehouseDetail->price + $product['price'];
                $warehouseDetail->save();
            }
        });
        $this->emit('refreshDatatable');
        $this->alert('success','Productos ingresados');
        $this->resetExcept();
    }

    public function render()
    {
        return view('livewire.logistic.warehouse.modal');
    }
}
