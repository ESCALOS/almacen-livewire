<?php

namespace App\Http\Livewire\Logistic\Requirement;

use App\Models\OrderDate;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use LivewireAlert;

    public $fechaPedido;
    public $open;
    public $orderDateId;
    public $endDate;

    public function rules(){
        return [
            'endDate' => 'required|date_format:Y-m-d H:i|after:now',
        ];
    }

    public function messages(){
        return [
            'endDate.required' => 'La fecha de cierre es requerida',
            'endDate.after' => 'La fecha de cierre debe ser mayor a la actual'
        ];
    }

    public function mount(){
        $this->fechaPedido = '';
        $this->open = false;
        $this->orderDateId = 0;
        $this->endDate = '';
    }

    public function openModal(){
        $this->open = true;
    }

    public function save(){
        $this->validate();
        if($this->orderDateId == 0){
            $lastOrder = new OrderDate();
            $lastOrder->start = Carbon::now()->format('Y-m-d H:i');
        }else{
            $lastOrder = OrderDate::latest()->first();
            if($lastOrder->closed){
                $this->alert('error', 'Pedido cerrado, Abra otro pedido');
                return;
            }
        }
        $lastOrder->end = $this->endDate;
        $lastOrder->save();
        $this->alert('success', 'Pedido abierto');
    }

    public function render()
    {
        $lastOrder = OrderDate::latest()->first();
        if($lastOrder && !$lastOrder->closed){
            $this->orderDateId = $lastOrder->id;
            $fecha = '2023-06-10 00:00:00';
            $this->fechaPedido = Carbon::createFromFormat('Y-m-d H:i:s', $lastOrder->start)->isoFormat('D [de] MMMM [del] YYYY');
        }else{
            $this->fechaPedido = 'no hay pedido';
            $this->orderDateId = 0;
        }

        return view('livewire.logistic.requirement.base',compact('lastOrder'));
    }
}
