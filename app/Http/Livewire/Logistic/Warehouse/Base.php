<?php

namespace App\Http\Livewire\Logistic\Warehouse;

use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Base extends Component
{
    use LivewireAlert;

    public $warehouseId;
    public $model = "WarehouseInput";
    public $columns = ['Producto','Descripcion','Categoria','Unidad de Medida','Abreviacion','Cantidad','Precio'];

    public function mount(){
        $this->warehouseId = Warehouse::exists() ? Warehouse::first()->id : 0;
    }

    public function updatedWarehouseId(){
        $this->warehouseId = is_null($this->warehouseId) ? 0 : $this->warehouseId;
        $this->emit('changeWarehouse',$this->warehouseId);
        $this->alert('info','Cargando...',[
            'timer' => null,
            'toast' => false,
            'position' => 'center'
        ]);
    }

    public function openModal(){
        if(Warehouse::where('id',$this->warehouseId)->exists()){
            $this->emitTo('logistic.warehouse.modal','openModal',$this->warehouseId);
        }else{
            $this->alert('warning','Seleccione un almacén',[
                'toast' => false,
                'position' => 'center',
                'timer' => 2000
            ]);
        }
    }

    public function openImportModal(){
        if(Warehouse::where('id',$this->warehouseId)->exists()){
            $this->emitTo('import-modal','openImportModal',$this->warehouseId);
        }else{
            $this->alert('warning','Seleccione un almacén',[
                'toast' => false,
                'position' => 'center',
                'timer' => 2000
            ]);
        }
    }


    public function render()
    {
        return view('livewire.logistic.warehouse.base');
    }
}
