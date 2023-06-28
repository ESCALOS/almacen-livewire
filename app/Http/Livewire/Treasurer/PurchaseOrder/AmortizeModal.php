<?php

namespace App\Http\Livewire\Treasurer\PurchaseOrder;

use App\Models\PartialPayment;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use PDOException;

class AmortizeModal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $purchaseOrderId = 0;
    public $missingAmount = 0;
    public $amount = 0;

    protected $listeners = ['openModal'];

    public function openModal($id){
        $this->purchaseOrderId = $id;
        $purchaseOrder = PurchaseOrder::find($id);
        $this->missingAmount = number_format($purchaseOrder->amount - $purchaseOrder->liquidated_amount,2);
        $this->open = true;
    }

    public function save(){
        if($this->amount > $this->missingAmount){
            $this->alert('warning', 'Ingresa una cantidad menor');
        }else{
            try{
                DB::transaction(function () {
                    $purchaseOrder = PurchaseOrder::find($this->purchaseOrderId);
                    $purchaseOrder->liquidated = $this->amount == $this->missingAmount;
                    $purchaseOrder->liquidated_amount += $this->amount;

                    $partialPayment = new PartialPayment();
                    $partialPayment->purchase_order_id = $this->purchaseOrderId;
                    $partialPayment->amount = $this->amount;

                    $purchaseOrder->save();
                    $partialPayment->save();

                    $this->alert('success', 'Acción éxitosa');
                    $this->reset('open','purchaseOrderId','missingAmount','amount');
                    $this->emit('refreshDatatable');
                });
            }catch(PDOException $e){
                $this->alert('error','Ocurrió un error: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.treasurer.purchase-order.amortize-modal');
    }
}
