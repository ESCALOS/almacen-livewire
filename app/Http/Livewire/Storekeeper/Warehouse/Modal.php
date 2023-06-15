<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\Warehouse;
use App\Models\WarehouseDepartment;
use App\Models\WarehouseDetail;
use App\Models\WarehouseInput;
use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId;
    public $departmentId;
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
            'departmentId' => 'required',
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.price' => 'required|numeric',
        ];
    }

    public function messages(){
        return [
            'departmentId' => 'El departamento es requerido',
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
            'products.*.price' => 'El precio es requerido',
        ];
    }

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

    public function openModal(){
        $this->resetExcept('open','warehouseId');
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

                $warehouseDepartment = WarehouseDepartment::firstOrCreate([
                    'warehouse_detail_id' => $warehouseDetail->id,
                    'department_id' => $this->departmentId
                ]);

                $warehouseInput = new WarehouseInput();
                $warehouseInput->warehouse_department_id = $warehouseDepartment->id;
                $warehouseInput->quantity = $product['quantity'];
                $warehouseInput->price = $product['price'];
                $warehouseInput->save();
            }
        });
        $this->alert('success','Productos ingresados');
        $this->resetExcept('warehouseId');
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal');
    }
}
