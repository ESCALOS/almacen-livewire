<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $productId;
    public $search;
    public $buttonActived;
    public $model;
    public $category;
    public $measurementUnit;

    protected $listeners = ['getProducts'];

    public function mount(){
        $this->productId = 0;
        $this->search = "";
        $this->buttonActived = false;
    }

    public function getProducts(){
        return Product::when($this->search != "",function($q){
            return $q->where('name','like',$this->search.'%');
        })->paginate(10);

    }

    public function openModal($id){
        $pid = $id == 0 ? 0 : $this->productId;
        if($id > 0 && $this->productId == 0){
            $this->alert('info','Seleccione un producto para edtiarlo');
        }else{
            $this->emitTo('logistic.product.modal','openModal',$pid);
            $this->alert('info', '¡Cargando...!', [
                'position' => 'center',
                'timer' => null,
                'toast' => false,
            ]);
        }
        
    }

    public function seleccionar($id){
        if($this->productId != $id){
            $this->productId = $id;
        }
    }

    public function delete(){
        if($this->productId == 0){
            $this->alert('info','Seleccione un producto para eliminar');
        }else{
            Product::find($this->productId)->delete();
            $this->productId = 0;
            $this->alert('success', '!Producto Eliminado!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        $this->buttonActived = $this->productId > 0;

        $products = $this->getProducts();

        return view('livewire.logistic.product.base',compact('products'));
    }
}
