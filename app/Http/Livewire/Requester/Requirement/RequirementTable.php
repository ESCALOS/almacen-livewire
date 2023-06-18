<?php

namespace App\Http\Livewire\Requester\Requirement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requirement;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class RequirementTable extends DataTableComponent
{
    protected $model = Requirement::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchLazy();
    }

    public function columns(): array
    {
        return [
            Column::make("id")
                ->isHidden(true),
            Column::make("Usuario", "user.name")
                ->sortable(),
            Column::make("Producto", "product.name")
                ->sortable(),
            Column::make('Cantidad', 'quantity'),
            BooleanColumn::make('¿Atendido?','met')
        ];
    }
}
