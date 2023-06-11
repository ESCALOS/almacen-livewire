<?php

namespace App\Http\Livewire\Logistic\Requirement;

use App\Models\OrderDate;
use Carbon\Carbon;
use Livewire\Component;

class Base extends Component
{

    public $fechaPedido;

    public function mount(){
        $this->fechaPedido = '';
    }

    public function render()
    {

        if($lastOrder = OrderDate::latest()->first()){
            $fecha = '2023-06-10 00:00:00';
            $this->fechaPedido = Carbon::createFromFormat('Y-m-d H:i:s', $lastOrder->start)->isoFormat('D [de] MMMM [del] YYYY');
        }else{
            $this->fechaPedido = 'no hay pedido';
        }

        return view('livewire.logistic.requirement.base',compact('lastOrder'));
    }
}
