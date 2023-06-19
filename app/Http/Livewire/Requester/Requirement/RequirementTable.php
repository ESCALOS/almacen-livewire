<?php

namespace App\Http\Livewire\Requester\Requirement;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Requirement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RequirementTable extends DataTableComponent
{
    use LivewireAlert;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['requirements.id']);
        $this->setSearchLazy();
        $this->setBulkActions([
            'edit' => 'Editar',
            'delete' => 'Eliminar',
        ]);
    }

    public function builder(): Builder
    {
        return Requirement::query()
            ->where('requirements.user_id',Auth::user()->id)
            ->orderBy('requirements.updated_at', 'DESC');
    }

    public function columns(): array
    {
        return [
            Column::make("Producto", "product.name")
                ->searchable()
                ->sortable(),
            Column::make('Cantidad', 'quantity'),
            BooleanColumn::make('¿Atendido?','met')
        ];
    }

    public function edit(): void
    {
        $products = null;
        foreach($this->getSelected() as $key => $value){
            $requirement = Requirement::find($value);
            if(!$requirement->met){
                $products[$key] = ['id' => $requirement->product_id, 'quantity' => $requirement->quantity];
            }
        }
        $this->emit('getProducts',$products);
    }

    public function delete(){
        $eliminados = 0;
        foreach ($this->getSelected() as $item) {
            try{
                $requirement = Requirement::find($item);
                if(!$requirement->met){
                   $requirement->delete();
                   $eliminados++;
                }
            }catch(\PDOException $e){
                $this->alert('error', $e->getMessage());
                return;
            }
        }
        if($eliminados>0){
            $this->clearSelected();
            $this->alert('success', '!Se eliminó '.$eliminados.' requerimientos!', [
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
