<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\WarehouseDetail;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WarehouseDetailTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = WarehouseDetail::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
        $this->setBulkActions([
            'dispatch' => 'Despachar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Producto','product.name')
                ->sortable(),
            Column::make('Cantidad','quantity')
                ->sortable()
        ];
    }

    public function dispatch(){
        $this->alert('info','Pendiente a programar');
    }
}
