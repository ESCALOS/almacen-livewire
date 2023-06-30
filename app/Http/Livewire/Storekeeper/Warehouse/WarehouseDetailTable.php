<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\Category;
use App\Models\MeasurementUnit;
use App\Models\WarehouseDetail;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;

class WarehouseDetailTable extends DataTableComponent
{
    use LivewireAlert;

    public $warehouseId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
        $this->setAdditionalSelects(['warehouse_details.id']);
        $this->setBulkActions([
            'dispatch' => 'Despachar',
        ]);
    }

    public function builder(): Builder
    {
        return WarehouseDetail::query()
            ->where('warehouse_id',$this->warehouseId);
    }

    public function columns(): array
    {
        return [
            Column::make('Producto','product.name')
                ->searchable()
                ->sortable(),
            Column::make('Cantidad','quantity')
                ->sortable()
        ];
    }

    public function filters(): array
    {
        return [
            MultiSelectFilter::make('Categoria')
            ->options(
                Category::query()
                    ->orderBy('name')
                    ->get()
                    ->keyBy('id')
                    ->map(fn($category) => $category->name)
                    ->toArray()
            )->filter(function(Builder $builder, $value) {
                    $builder->where('category_id', $value);
            }),

            MultiSelectFilter::make('Unidad de Medida')
            ->options(
                MeasurementUnit::query()
                    ->orderBy('name')
                    ->get()
                    ->keyBy('id')
                    ->map(fn($measurementUnit) => $measurementUnit->name)
                    ->toArray()
            )->filter(function(Builder $builder, $value) {
                    $builder->where('measurement_unit_id', $value);
            }),
        ];
    }

    public function dispatch(){
        $this->alert('info','Pendiente a programar');
    }
}
