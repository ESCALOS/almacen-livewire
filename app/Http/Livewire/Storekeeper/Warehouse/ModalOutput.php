<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModalOutput extends Component
{
    use LivewireAlert;

    public $open = false;
    public $warehouseId = 0;

    protected $listeners = ['openModal'];

    public function mount($warehouseId){
        $this->warehouseId = $warehouseId;
    }

    public function openModal(){
        $this->open = true;
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.modal-output');
    }
}
