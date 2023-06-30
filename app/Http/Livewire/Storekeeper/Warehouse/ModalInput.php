<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\PurchaseOrderDetail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ModalInput extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId;
    public $purchaseOrderId = 0;
    public $details = array();

    protected $listeners = ['openModal'];

    public function rules()
    {
        return [
            'details.*.quantity_to_enter' => 'required|numeric|lte:details.*.quantity_to_enter',
        ];
    }

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

    public function openModal(){
        $this->reset('purchaseOrderId');
        $this->open = true;
    }

    public function updatedPurchaseOrderId(): array {
        $details = array();
        if($this->purchaseOrderId){
            $purchaseDetails = PurchaseOrderDetail::where('purchase_order_id',$this->purchaseOrderId)->get();
            foreach($purchaseDetails as $index => $detail){
                $this->details[$index]['id'] = $detail->id;
                $this->details[$index]['product'] = $detail->Product->name;
                $this->details[$index]['quantity'] = $detail->quantity - $detail->entered_quantity;
                $this->details[$index]['quantity_to_enter'] = $this->details[$index]['quantity'];
            }
        }
        return $details;
    }

    public function save(){
        $this->validate();
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal-input');
    }
}
