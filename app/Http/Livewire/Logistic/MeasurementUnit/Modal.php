<?php

namespace App\Http\Livewire\Logistic\MeasurementUnit;

use App\Models\MeasurementUnit;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $measurementUnitId = 0;
    public $name = "";
    public $abbreviation = "";

    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'name' => 'required|unique:measurement_units,name,'.$this->measurementUnitId,
            'abbreviation' => 'required|unique:measurement_units,abbreviation,'.$this->abbreviation
        ];
    }

    public function messages(){
        return [
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'La unidad de medida ya existe',
            'abbreviation.required' => 'La abreviación es requerida',
            'abreviation.unique' => 'La unidad de medida ya existe'
        ];
    }

    public function openModal($id){
        $this->measurementUnitId = $id;
        if($id){
            $measurementUnit = MeasurementUnit::find($id);
            $this->name = $measurementUnit->name;
            $this->abbreviation = $measurementUnit->abbreviation;
        }else{
            $this->resetExcept('open','measurementUnitId');
        }
        $this->open = true;
    }

    public function updatedOpen(){
        if(!$this->open){
            $this->resetExcept('open');
        }
    }

    public function save(){
        $this->validate();
        if($this->measurementUnitId == 0){
            $measurementUnit = new MeasurementUnit();
        }else{
            $measurementUnit = MeasurementUnit::find($this->measurementUnitId);
        }
            $measurementUnit->name = strtoupper($this->name);
            $measurementUnit->abbreviation = strtoupper($this->abbreviation);
            $measurementUnit->save();
            $this->emitTo('logistic.product.modal','putMeasurementUnit',$measurementUnit->id);
            $this->open = false;
            $action = $this->measurementUnitId == 0 ? 'Agregada' : 'Editada';
            $this->alert('success', '¡Unidad de Medida '.$action.'!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
    }

    public function render()
    {
        return view('livewire.logistic.measurement-unit.modal');
    }
}
