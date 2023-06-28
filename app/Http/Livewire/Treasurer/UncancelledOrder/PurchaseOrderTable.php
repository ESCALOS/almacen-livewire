<?php

namespace App\Http\Livewire\Treasurer\UncancelledOrder;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PurchaseOrderTable extends DataTableComponent
{
    use LivewireAlert;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
    }

    public function builder(): Builder
    {
        return PurchaseOrder::query()
            ->where('purchase_orders.liquidated',false)
            ->orderBy('purchase_orders.updated_at', 'DESC');
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
                ->format(fn ($value) => $value ? 'CRÉDITO' : 'CONTADO'),
            BooleanColumn::make("¿Está cancelado?", "liquidated"),
            Column::make('Fecha','created_at'),
        ];
    }
}
