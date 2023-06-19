<?php

namespace App\Http\Livewire\Requester\Requirement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requirement;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class RequirementTable extends DataTableComponent
{
    protected $model = Requirement::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
        $this->setBulkActions([
            'edit' => 'Editar',
            'delete' => 'Eliminar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("id")
                ->isHidden(true),
            Column::make("Producto", "product.name")
                ->sortable(),
            Column::make('Cantidad', 'quantity'),
            BooleanColumn::make('¿Atendido?','met')
        ];
    }

    public function edit(){
        $products = [];
        foreach($this->getSelected() as $key => $value){
            $requirement = Requirement::find($value);
            if(!$requirement->met){
                $products[$key] = ['id' => $requirement->product_id, 'quantity' => $requirement->quantity];
            }
        }
        $this->emit('getProducts',$products);
    }
}
