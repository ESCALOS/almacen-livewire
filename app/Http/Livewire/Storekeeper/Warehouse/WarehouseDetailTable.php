<?php

namespace App\Http\Livewire\Storekeeper\Warehouse;

use App\Models\Category;
use App\Models\MeasurementUnit;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\WarehouseDetail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class WarehouseDetailTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = WarehouseDetail::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
        $this->setSearchVisibilityStatus(true);
        $this->setBulkActions([
            'dispatch' => 'Despachar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make('id')
                ->hideIf(true),
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
