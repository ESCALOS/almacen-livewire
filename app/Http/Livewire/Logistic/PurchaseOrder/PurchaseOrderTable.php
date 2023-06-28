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
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Proveedor", "supplier.name")
                ->sortable(),
            Column::make("Método de Pago", "credit")
                ->format(fn ($value) => $value ? 'CRÉDITO' : 'CONTADO'),
            BooleanColumn::make("¿Está cancelado?", "liquidated"),
            Column::make('Fecha','created_at'),
            Column::make('Detalle', 'id')
                ->format(fn ($value) => view('components.table-button', ['id' => $value,'icon' => 'information']))
        ];
    }

    public function action($id){
        $this->emitTo('logistic.purchase-order.modal','openModal',$id);
    }
}
