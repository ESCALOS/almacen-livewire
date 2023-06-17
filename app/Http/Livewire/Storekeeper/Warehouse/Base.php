<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Base extends Component
{

    public $warehouseId;

    public function mount(){
        try{
            $this->warehouseId = User::find(Auth::user()->id)->Warehouse[0]->id;
        }catch(\Exception $e){
            $this->warehouseId = 0;
        }
    }

    public function openModal(){
        $this->emitTo('storekeeper.warehouse.modal','openModal',0);
    }

    public function render()
    {
        return view('livewire.storekeeper.warehouse.base');
    }
}
