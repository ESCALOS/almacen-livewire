<?php

namespace App\Http\Livewire\Logistic\Requirement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RequirementTable extends DataTableComponent
{
    use LivewireAlert;
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['requirements.id']);
        $this->setSearchLazy();
        $this->setBulkActions([
            'openModal' => 'Crear Orden de Compra',
        ]);
    }

    public function builder(): Builder
    {
        return Requirement::query()
            ->where('requirements.met',false)
            ->orderBy('requirements.updated_at', 'DESC');
    }

    public function columns(): array
    {
        return [
            Column::make("Usuario", "user.name")
                ->sortable()
                ->searchable(),
            Column::make('Area','user.department.name')
                ->sortable()
                ->searchable(),
            Column::make("Producto", "product.name")
                ->searchable()
                ->sortable(),
            Column::make("Cantidad", "quantity"),
            Column::make("Fecha", "created_at")
                ->sortable(),
        ];
    }

    public function openModal(): void
    {
        $products = [];
        $i = 0;
        foreach($this->getSelected() as $id){
            $requirement = Requirement::find($id);
            if(!$requirement->met){
                $index = $this->validateProduct($products,$requirement->product_id);
                if($index == -1){
                    $products[$i] = ['id' => $requirement->product_id, 'quantity' => $requirement->quantity, 'price' => ''];
                    $i++;
                }else{
                    $products[$index]['quantity'] = $products[$index]['quantity'] + $requirement->quantity;
                }

            }
        }
        if($products == []){
            $this->alert('warning','Requiremientos ya atendidos');
        }else{
            $this->emit('getProducts',$products);
        }
    }

    private function validateProduct($products,$id): int{
        foreach($products as $index => $product){
            if($product['id'] == $id){
                return $index;
            }
        }
        return -1;
    }
}
