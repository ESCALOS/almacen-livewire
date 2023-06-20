<?php

namespace App\Http\Livewire\Logistic\Requirement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Builder;

class RequirementTable extends DataTableComponent
{
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
        $products = null;
        $i = 0;
        foreach($this->getSelected() as $value){
            $requirement = Requirement::find($value);
            if(!$requirement->met){
                $products[$i] = ['id' => $requirement->product_id, 'quantity' => $requirement->quantity];
                $i++;
            }
        }
        if($products == null){
            $this->alert('warning','Requiremientos ya atendidos');
        }else{
            $this->emit('getProducts',$products);
        }
    }
}
