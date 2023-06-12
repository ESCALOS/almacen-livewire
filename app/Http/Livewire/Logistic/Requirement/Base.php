<?php

namespace App\Http\Livewire\Logistic\Requirement;

use App\Models\OrderDate;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use LivewireAlert;

    public $title;
    public $open;
    public $orderDateId;
    public $endDate;
    public $closed;

    protected $listeners = ['closeConfirmed'];
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
        $this->title = '';
        $this->open = false;
        $this->orderDateId = 0;
        $this->endDate = '';
        $this->closed = true;
    }

    public function openModal(){
        if($this->orderDateId == 0){
            $this->endDate = '';            
        }else{
            $this->endDate = OrderDate::find($this->orderDateId)->end;
        }
        $this->open = true;
    }

    public function closeOrder(){
        if($this->orderDateId == 0){
            $this->alert('warning','No hay orden abierta');
            $this->render();
        }else{
            $this->alert('question', '¿Estás seguro de cerrar el pedido?', [
                'showConfirmButton' => true,
                'confirmButtonText' => 'Sí',
                'showCancelButton' => true,
                'cancelButtonText' => 'No',
                'position' => 'center',
                'toast' => false,
                'onConfirmed' => 'closeConfirmed',
                'timer' => 15000
            ]);
        }
    }

    public function closeConfirmed(){
        if($this->orderDateId > 0){
            $orderDate = OrderDate::find($this->orderDateId);
            $orderDate->closed = true;
            $orderDate->save();

        }
        $this->alert('success','Pedido Cerrado'.$this->orderDateId);
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
        $this->open = false;
        if($this->orderDateId == 0){
            $this->alert('success', 'Pedido Abierto');
        }else{
            $this->alert('success', 'Cierre de Pedido Modificado');
        }
        
    }

    public function render()
    {
        $lastOrder = OrderDate::latest()->first();
        if(!$lastOrder || $lastOrder->closed){
            $this->title = 'No hay pedido abierto';
            $this->orderDateId = 0;
            $this->closed = true;
        }else{
            $this->closed = false;
            if($lastOrder->end < Carbon::now()){
                $this->title = 'Cerró '.Carbon::parse($lastOrder->end)->diffForHumans();
            }else{
                $this->orderDateId = $lastOrder->id;
                $this->title = 'Cierra '.Carbon::parse($lastOrder->end)->diffForHumans();
            }
        }

        return view('livewire.logistic.requirement.base',compact('lastOrder'));
    }
}
