<?php

namespace App\Http\Livewire\Logistic\Product;

use Livewire\Component;

class Base extends Component
{
    public $model = "Product";
    public $columns = ['Producto','Descripcion','Categoria','Unidad de Medida','Abreviacion'];

    public function openModal(){
        $this->emitTo('logistic.product.modal','openModal',0);
    }

    public function openImportModal(){
        $this->emitTo('import-modal','openImportModal');
    }

    public function render()
    {
        return view('livewire.logistic.product.base');
    }
}
