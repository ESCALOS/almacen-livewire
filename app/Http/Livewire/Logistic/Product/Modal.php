<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $productId = 0;
    public $name = '';
    public $description = '';
    public $measurementUnit = '';
    public $category = '';

    protected $listeners = ['openModal','putCategory','putMeasurementUnit'];

    public function rules(){
        return [
            'name' => 'required|unique:products,name,'.$this->productId,
            'category' => 'required|exists:categories,id',
            'measurementUnit' => 'required|exists:measurement_units,id',
        ];
    }

    public function messages(){
        return [
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'El producto ya existe',
            'category.required' => 'La categoria es requerida',
            'measurementUnit.required' => 'La unidad de medida es requerida',
        ];
    }

    public function openModal($id) {
        $this->productId = $id;
        if($id){
            $product = Product::find($id);
            $this->name = $product->name;
            $this->description = $product->description;
            $this->measurementUnit = $product->measurement_unit_id;
            $this->category = $product->category_id;
        }else{
            $this->resetExcept('open','productId');
        }
        $this->open = true;
    }

    public function putCategory($id) {
        $this->category = $id;
    }

    public function putMeasurementUnit($id){
        $this->measurementUnit = $id;
    }

    public function save(){
        $this->validate();
        if($this->productId){
            $product = Product::find($this->productId);
        }else{
            $product = new Product();
        }

        $product->name = strtoupper($this->name);
        $product->description = strtoupper($this->description);
        $product->category_id = $this->category;
        $product->measurement_unit_id = $this->measurementUnit;
        try{
            $product->save();
            $this->open = false;
            $this->emit('refreshDatatable');
            $action = $this->productId == 0 ? 'Agregado' : 'Editado';
            $this->alert('success', '¡Producto '.$action.'!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }catch(\PDOException $e){
            $this->alert('success', $e->getMessage(), [
                'position' => 'center',
                'timer' => 3500,
                'toast' => false,
            ]);
        }
    }

    public function delete(){
        try{
            Product::find($this->productId)->delete();
            $this->emit('clearSelected');
            $this->open = false;
        }catch(\PDOException $e){
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.logistic.product.modal');
    }
}
