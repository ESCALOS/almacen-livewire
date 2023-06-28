<?php

namespace App\Http\Livewire\Treasurer\PurchaseOrder;

use App\Models\PartialPayment;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PurchaseOrder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use PDOException;

class PurchaseOrderTable extends DataTableComponent
{
    use LivewireAlert;

    protected $model = PurchaseOrder::class;
    protected $listeners = [
        'refreshDatatable' => '$refresh',
        'clearSelected' => 'clearSelected',
        'liquidate' => 'liquidate',
        'liquidateBulk' => 'liquidateBulk',
    ];

    public $purchaseOrderId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['purchase_orders.id', 'purchase_orders.liquidated','liquidated_amount']);
        $this->setSearchLazy();
        $this->setBulkActions([
            'confirmBulk' => 'Liquidar',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Proveedor", "supplier.name")
                ->searchable()
                ->sortable()
                ->collapseOnTablet(),
            Column::make("Método de Pago", "credit")
                ->format(fn ($value) => $value ? 'CRÉDITO' : 'CONTADO')
                ->collapseOnTablet(),
            Column::make("Por pagar", "amount")
                ->format(fn ($value,$row) => 'S/.'.number_format($value - $row['liquidated_amount'],2))
                ->collapseOnTablet(),
            Column::make('Fecha','created_at')
                ->collapseOnTablet(),
            Column::make('Estado', 'id')
                ->format(fn ($value,$row) => view('button-liquidate', [
                    'id' => $value,
                    'credit' => $row['credit'],
                    'liquidated' => $row['liquidated']
                ]))
        ];
    }

    public function filters(): array
    {
        return [
            SelectFilter::make('Método de Pago','credit')
                ->options([
                    '' => 'Todos',
                    '1' => 'Crédito',
                    '0' => 'Contado',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('credit', true);
                    } elseif ($value === '0') {
                        $builder->where('credit', false);
                    }
                }),
            SelectFilter::make('Estado','liquidated')
                ->options([
                    '' => 'Todos',
                    '1' => 'Liquidado',
                    '0' => 'No liquidado',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('liquidated', true);
                    } elseif ($value === '0') {
                        $builder->where('liquidated', false);
                    }
                }),
        ];
    }

    public function confirmLiquidate($id){
        if(PurchaseOrder::find($id)->liquidated){
            $this->alert('warning',"Orden ya liquidada");
        }else{
            $this->purchaseOrderId = $id;
            $this->alert('question', '¿Seguro que desea liquidar?', [
                'showConfirmButton' => true,
                'confirmButtonText' => 'Sí',
                'showDenyButton' => true,
                'denyButtonText' => 'No',
                'onConfirmed' => 'liquidate',
                'position' => 'center',
                'toast' => false,
                'timer'=> null
            ]);
        }

    }

    public function liquidate(){
        try{
            DB::transaction(function(){
                $purchaseOrder = PurchaseOrder::find($this->purchaseOrderId);
                $purchaseOrder->liquidated = true;
                $purchaseOrder->liquidated_amount = $purchaseOrder->amount;

                $partialPayment = new PartialPayment();
                $partialPayment->purchase_order_id = $purchaseOrder->id;
                $partialPayment->amount = $purchaseOrder->amount;

                $purchaseOrder->save();
                $partialPayment->save();
                $this->alert("success","Liquidado");
            });
        }catch(PDOException $e){
            $this->alert('error','Ocurrió un error: ' . $e->getMessage());
        }
    }

    public function confirmBulk(){
        $this->purchaseOrderId = $this->getSelected();
        $this->alert('question', '¿Seguro que desea liquidar?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'showDenyButton' => true,
            'denyButtonText' => 'No',
            'onConfirmed' => 'liquidateBulk',
            'position' => 'center',
            'toast' => false,
            'timer'=> null
        ]);
    }

    public function liquidateBulk(){
        try{
            DB::transaction(function(){
                foreach($this->purchaseOrderId as $id){
                    $purchaseOrder = PurchaseOrder::find($id);
                    if(!$purchaseOrder->liquidated){
                        $purchaseOrder->liquidated = true;
                        $purchaseOrder->liquidated_amount = $purchaseOrder->amount;

                        $partialPayment = new PartialPayment();
                        $partialPayment->purchase_order_id = $purchaseOrder->id;
                        $partialPayment->amount = $purchaseOrder->amount;

                        $purchaseOrder->save();
                        $partialPayment->save();
                    }
                }
            });
            $this->alert("success","Liquidado");
        }catch(PDOException $e){
            $this->alert('error','Ocurrió un error: ' . $e->getMessage());
        }
    }
}
