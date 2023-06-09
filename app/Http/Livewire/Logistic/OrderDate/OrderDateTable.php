<?php

namespace App\Http\Livewire\Logistic\OrderDate;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrderDate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

class OrderDateTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = OrderDate::class;

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
            Column::make("Fecha Inicial", "start")
                ->sortable(),
            Column::make("Fecha Final", "end")
                ->sortable(),
        ];
    }
}
