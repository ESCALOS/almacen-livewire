<?php

namespace App\Http\Livewire\Logistic\PurchaseOrder;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class PurchaseOrderTable extends DataTableComponent
{
    protected $model = PurchaseOrder::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Proveedor", "supplier.name")
                ->searchable()
                ->sortable(),
            Column::make("Método de Pago", "credit")
                ->searchable()
                ->format(fn ($value) => $value ? 'CRÉDITO' : 'CONTADO'),
            BooleanColumn::make("¿Cancelado?", "liquidated"),
            Column::make("Monto", "amount")
                ->format(fn ($value) => 'S/.'.$value),
            Column::make('Fecha','created_at'),
            Column::make('Detalle', 'id')
                ->format(fn ($value) => view('components.table-button', ['id' => $value,'icon' => 'information']))
        ];
    }

    public function action($id){
        $this->emitTo('logistic.purchase-order.modal','openModal',$id);
    }
}
