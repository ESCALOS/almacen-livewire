<?php

namespace App\Http\Livewire\Logistic\Product;

use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
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
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'clearSelected' => 'clearSelected',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['products.id']);
        $this->setSearchLazy();
        $this->setBulkActions([
            'delete' => 'Eliminar',
            'export' => 'Exportar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Descripción", "description")
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

    public function edit($id){
        $this->emitTo('logistic.product.modal','openModal',$id);
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

    public function export()
    {
        $products = $this->getSelected();

        $this->clearSelected();

        return Excel::download(new ProductsExport(), 'users.xlsx');
    }

    public function delete(){
        $eliminados = 0;
        foreach ($this->getSelected() as $item) {
            try{
                Product::find($item)->delete();
            }catch(\PDOException $e){
                $this->alert('error', $e->getMessage());
                return;
            }
            $eliminados++;
        }
        if($eliminados>0){
            $this->clearSelected();
            $this->alert('success', '!Se eliminó '.$eliminados.' productos!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->refreshDatatable();
            $this->alert('error', '!No se eliminó nada!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }
    }
}
