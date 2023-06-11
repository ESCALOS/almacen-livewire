<?php

namespace App\Http\Livewire\Logistic\OrderDate;

use App\Models\OrderDate;
use Livewire\Component;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $orderDateId;
    public $startDate;
    public $endDate;
    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'startDate' => 'required|date_format:Y-m-d H:i:s|after_or_equal:today',
            'endDate' => 'required|date_format:Y-m-d H:i:s|after:'.$this->startDate,
        ];
    }

    public function messages(){
        return [
            'startDate.required' => 'La fecha inicial es requerida',
            'startDate.after_or_equal' => 'La fecha inicial debe ser mayor a la actual',
            'endDate.required' => 'La fecha final es requerida',
            'endDate.after' => 'La fecha final debe ser mayor que la actual'
        ];
    }

    public function mount(){
        $this->open = false;
        $this->startDate = '';
        $this->endDate = '';
    }

    public function openModal($id) {
        $this->orderDateId = $id;
        if($id > 0){
            $orderDate = OrderDate::find($id);
            $this->startDate = $orderDate->start;
            $this->endDate = $orderDate->end;
        }else{
            $this->startDate = Carbon::today()->format('Y-m-d H:i:s');
            $this->endDate = Carbon::tomorrow()->format('Y-m-d H:i:s');
        }
        $this->open = true;
    }

    public function save(){
        $this->validate();
        if($this->orderDateId == 0){
            $orderDate = new OrderDate();
            $orderDate->start = $this->startDate;
        }else{
            $orderDate = OrderDate::find($this->orderDateId);
        }
        $orderDate->end = $this->endDate;
        try{
            $orderDate->save();
            $this->open = false;
            $this->emit('refreshDatatable');
            $action = $this->orderDateId == 0 ? 'Agregado' : 'Editado';
            $this->alert('success', '¡Fecha de Pedido '.$action.'!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }catch(\PDOException $e){
            $this->alert('error', $e->getMessage(), [
                'position' => 'center',
                'timer' => 10000,
                'toast' => false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.logistic.order-date.modal');
    }
}
