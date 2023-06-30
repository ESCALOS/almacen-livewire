<?php

namespace App\Http\Livewire\Logistic\Category;

use App\Models\Category;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open = false;
    public $categoryId = 0;
    public $name = "";
    public $description = "";

    protected $listeners = ['openModal'];

    public function rules(){
        return [
            'name' => 'required|unique:categories,name,'.$this->categoryId,
        ];
    }

    public function messages(){
        return [
            'name.required' => 'El nombre es requerido',
            'name.unique' => 'La categoría ya existe'
        ];
    }

    public function openModal($id){
        $this->categoryId = $id;
        if($id){
            $category = Category::find($id);
            $this->name = $category->name;
            $this->description = $category->description;
        }else{
            $this->resetExcept('open','categoryId');
        }
        $this->open = true;
    }

    public function save(){
        $this->validate();
        if($this->categoryId == 0){
            $category = new Category();
        }else{
            $category = Category::find($this->categoryId);
        }
            $category->name = strtoupper($this->name);
            $category->description = strtoupper($this->description);
            $category->save();
            $this->emitTo('logistic.product.modal','putCategory',$category->id);
            $this->open = false;
            $action = $this->categoryId == 0 ? 'Agregada' : 'Editada';
            $this->alert('success', '!Categoría '.$action.'!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
    }

    public function render()
    {
        return view('livewire.logistic.category.modal');
    }
}
