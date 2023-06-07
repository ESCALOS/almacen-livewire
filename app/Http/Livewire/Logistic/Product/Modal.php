<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Models\Product;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $productId;
    public $name;
    public $description;
    public $measurementUnit;
    public $category;

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

    public function mount(){
        $this->open = false;
        $this->productId = 0;
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->measurementUnit = '';
    }

    public function openModal($id) {
        $this->productId = $id;
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
        if($this->productId == 0){
            $product = new Product();
        }else{
            $product = Product::find($this->productId);
        }

        $product->name = strtoupper($this->name);
        $product->description = strtoupper($this->description);
        $product->category_id = $this->category;
        $product->measurement_unit_id = $this->measurementUnit;
        $product->save();
        $this->open = false;
        $action = $this->productId == 0 ? 'Agregado' : 'Editado';
        $this->alert('success', '¡Producto '.$action.'!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
        ]);
        $this->productId = 0;
    }

    public function render()
    {
        return view('livewire.logistic.product.modal');
    }
}
