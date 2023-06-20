<?php

namespace App\Http\Livewire\Logistic\Warehouse;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\WarehouseDetail;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WarehouseDetailTable extends DataTableComponent
{
    use LivewireAlert;

    public $warehouseId;

    protected $listeners = [
        'changeWarehouse',
        'refreshDatatable' => '$refresh',
        'clearSelected' => 'clearSelected'
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['warehouse_details.id']);
        $this->setSearchLazy();
    }

    public function builder(): Builder
    {
        return WarehouseDetail::query()
            ->where('warehouse_id',$this->warehouseId);
    }

    public function columns(): array
    {
        return [
            Column::make("Producto", "product.name")
                ->searchable()
                ->sortable(),
            Column::make("Cantidad", "quantity")
                ->sortable(),
            Column::make("Precio", "price")
                ->sortable()
                ->collapseOnTablet(),
        ];
    }

    public function changeWarehouse($warehouseId): void
    {
        $this->warehouseId = $warehouseId;
        $this->emit('refreshDatatable');
        $this->alert('success','Datos Cargados');
    }
}
