<?php

namespace App\Http\Livewire\Logistic\Category;

use App\Models\Category;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $categoryId;
    public $name;
    public $description;

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

    public function mount(){
        $this->open = false;
        $this->categoryId = 0;
    }

    public function openModal($id){
        $this->name = "";
        $this->description = "";
        $this->categoryId = $id;
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
