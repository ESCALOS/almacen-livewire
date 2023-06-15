<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\User;
use App\Models\UserWarehouse;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Base extends Component
{

    public $warehouseId;

    public function mount(){
        $this->warehouseId = User::find(Auth::user()->id)->Warehouse[0]->id;
    }

    public function openModal(){
        $this->emitTo('storekeeper.warehouse.modal','openModal',0);
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.base');
    }
}
