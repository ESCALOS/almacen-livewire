<?php

namespace App\Http\Livewire\Logistic\PurchaseOrder;

use App\Models\PurchaseOrder;
use Livewire\Component;

class Modal extends Component
{
    public $open = false;
    public $purchaseOrderId = 0;

    protected $listeners = ['openModal'];

    public function openModal($id){
        $this->reset('purchaseOrderId');
        $this->purchaseOrderId = $id;
        $this->open = true;
    }

    public function render()
    {
        if($this->purchaseOrderId){
            $purchaseOrder = PurchaseOrder::find($this->purchaseOrderId);
        }else{
            $purchaseOrder = null;
        }
        return view('livewire.logistic.purchase-order.modal',compact('purchaseOrder'));
    }
}
