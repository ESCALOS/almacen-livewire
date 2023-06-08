<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use LivewireAlert;

    public $productId;

    public function mount(){
        $this->productId = 0;
    }

    public function openModal($id){
        $pid = $id == 0 ? 0 : $this->productId;
        if($id > 0 && $this->productId == 0){
            $this->alert('info','Seleccione un producto para edtiarlo');
        }else{
            $this->emitTo('logistic.product.modal','openModal',$pid);
        }
        
    }

    public function render()
    {
        return view('livewire.logistic.product.base');
    }
}
