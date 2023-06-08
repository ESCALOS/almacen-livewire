<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Models\Category;
use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;

class ProductTable extends DataTableComponent
{
    use LivewireAlert;
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
        $this->setBulkActions([
            'delete' => 'Eliminar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Descripción", "description")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Categoria", "category.name")
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Unidad de Medida", "measurementunit.name")
                ->sortable()
                ->collapseOnTablet(),

            ComponentColumn::make('Acciones', 'id')
                ->component('edit'),
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

    public function delete(){
        foreach ($this->getSelected() as $item) {
            Product::find($item)->delete();
        }
        $this->clearSelected();
        $this->alert('success', '!Productos Eliminado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
        ]);
    }
}
