<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\WarehouseDetail;
use App\Models\WarehouseOutput;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PDOException;

class ModalOutput extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId;
    public $userId = '';
    public $reasonId = '';
    public $products = [
        [
            'id' => '',
            'quantity' => '',
            'quantity_to_leave' => '',
        ]
    ];

    protected $listeners = ['openModal','getProducts'];

    public function rules(){
        return [
            'products.*.id' => 'required',
            'products.*.quantity' => 'required|numeric',
            'products.*.quantity_to_leave' => 'required|numeric|gt:0|lte:products.*.quantity',
        ];
    }

    public function messages(){
        return [
            'products.*.id' => 'El producto es requerido',
            'products.*.quantity' => 'La cantidad es requerida',
            'products.*.quantity_to_leave.required' => 'Lo despachado es requerido',
            'products.*.quantity_to_leave.numeric' => 'Lo despachado debe ser un número',
            'products.*.quantity_to_leave.lte' => 'Lo despachado debe ser como máximo :value.',
            'products.*.quantity_to_leave.gt' => 'Lo despachado debe ser mayor a 0.',
        ];
    }

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

    public function updated(){
        foreach($this->products as &$product){
            if($product['id'] !== ''){
                $warehouseDetail = WarehouseDetail::where('warehouse_id',$this->warehouseId)->where('product_id',$product['id'])->first();
                $product['quantity'] = $warehouseDetail != null ? $warehouseDetail->quantity : 0;
            }
        }
    }

    public function openModal(){
        $this->reset('userId','reasonId','products');
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
            'quantity_to_leave' => '',
        ];
    }

    public function removeProduct($index){
        unset($this->products[$index]);
        $this->products = array_values($this->products);
    }

    public function save(){
        $this->validate();
        try{
            DB::transaction(function(){
                foreach ($this->products as $product) {
                    $warehouseDetail = WarehouseDetail::where('product_id', $product['id'])->where('warehouse_id', $this->warehouseId)->first();
                    if($product['quantity_to_leave']<=$warehouseDetail['quantity']){
                        $warehouseOutput = new WarehouseOutput();
                        $warehouseOutput->warehouse_detail_id = $warehouseDetail->id;
                        $warehouseOutput->quantity = $product['quantity_to_leave'];
                        $warehouseOutput->price = $product['quantity_to_leave']/$warehouseDetail['quantity']*$warehouseDetail->price;
                        $warehouseOutput->reason_id = $this->reasonId;
                        $warehouseOutput->user_id = $this->userId;
                        $warehouseOutput->save();
                    }else{
                        throw new Exception('Se anula la transacción');
                    }
                }
            });
        }catch(PDOException $e){
            $this->alert('error','Error en el servidor: ' . $e->getMessage());
        }catch(Exception $e){
            $this->alert('error','Error en el servidor: ' . $e->getMessage());
        }
        $this->emit('refreshDatatable');
        $this->alert('success','Productos Solicitados');
        $this->reset('open','userId','reasonId','products');
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal-output');
    }
}
