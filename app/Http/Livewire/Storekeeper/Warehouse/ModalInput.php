<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\WarehouseDetail;
use App\Models\WarehouseInput;
use Exception;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use PDOException;

class ModalInput extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId;
    public $purchaseOrderId = '';
    public $details = array();

    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'details.*.quantity_to_enter' => 'required|numeric|min:0|lte:details.*.quantity',
        ];
    }

    public function messages(){
        return [
            'details.*.quantity_to_enter.required' => 'Lo recibido es requerido',
            'details.*.quantity_to_enter.numeric' => 'Lo recibido debe ser un número',
            'details.*.quantity_to_enter.lte' => 'Lo recibido debe ser como máximo :value.',
            'details.*.quantity_to_enter.min' => 'Lo recibido debe ser mayor a 0.',
        ];
    }

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

    public function openModal(){
        $this->reset('purchaseOrderId','details');
        $this->open = true;
    }

    public function updatedPurchaseOrderId(){
        $this->reset('details');
        if($this->purchaseOrderId != '' && $this->purchaseOrderId){
            $purchaseDetails = PurchaseOrderDetail::where('purchase_order_id',$this->purchaseOrderId)->where('quantity','!=',DB::raw('entered_quantity'))->get();
            foreach($purchaseDetails as $index => $detail){
                $this->details[$index]['id'] = $detail->id;
                $this->details[$index]['product_id'] = $detail->product_id;
                $this->details[$index]['product'] = $detail->Product->name;
                $this->details[$index]['quantity'] = $detail->quantity - $detail->entered_quantity;
                $this->details[$index]['quantity_to_enter'] = $this->details[$index]['quantity'];
                $this->details[$index]['price'] = $detail->price;
            }
        }
    }

    public function save(){
        $this->validate();
        try {
            DB::transaction(function () {
                $completed = true;
                foreach($this->details as $detail){
                    //Orden de compra
                    $purchaseOrderDetails = PurchaseOrderDetail::find($detail['id']);
                    $purchaseOrderDetails->entered_quantity += $detail['quantity_to_enter'];
                    $purchaseOrderDetails->save();
                    //Almacen
                    $warehouseDetail = WarehouseDetail::firstOrCreate([
                        'warehouse_id' => $this->warehouseId,
                        'product_id' => $detail['product_id'],
                    ]);
                    $warehouseInput = new WarehouseInput();
                    $warehouseInput->warehouse_detail_id = $warehouseDetail->id;
                    $warehouseInput->purchase_order_detail_id = $detail['id'];
                    $warehouseInput->quantity = $detail['quantity_to_enter'];
                    $warehouseInput->price = $detail['price']*$detail['quantity_to_enter']/$detail['quantity'];
                    if($completed){
                        $completed = $detail['quantity'] == $detail['quantity_to_enter'];
                    }
                    $warehouseInput->save();
                }
                if($completed){
                    $purchaseOrder = PurchaseOrder::find($this->purchaseOrderId);
                    $purchaseOrder->completed = true;
                    $purchaseOrder->save();
                }
                $this->alert('success','Ingreso exitoso');
                $this->emit('refreshDatatable');
                $this->reset('purchaseOrderId','details','open');
            });
        } catch (PDOException $e) {
            $this->alert('error','Error en el servidor: '. $e->getMessage());
        } catch (Exception $e){
            $this->alert('error','Error en el servidor: '. $e->getMessage());
        }


    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal-input');
    }
}
