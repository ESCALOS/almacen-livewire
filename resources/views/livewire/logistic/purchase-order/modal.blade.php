<x-modal.card title="Detalle de Orden de Compra" blur wire:model.defer="open">
    @if($purchaseOrderId)
    <div class="grid grid-cols-2 gap-4 px-4 pb-4">
        <x-input type="number" readonly label="RUC" max="20999999999" value="{{ $purchaseOrder->Supplier->ruc }}"/>
        <x-input type="text" readonly label="Proveedor" value="{{ $purchaseOrder->Supplier->name }}"/>
        <x-input type="text" readonly label="Dirección" value="{{ $purchaseOrder->Supplier->address }}"/>
        <x-input type="text" readonly label="Método de Pago" value="{{ $purchaseOrder->credit ? 'CRÉDITO' : 'CONTADO' }}"/>

    </div>
    <hr>
    @foreach ($purchaseOrder->PurchaseOrderDetails as $detalle)
    <div class="grid grid-cols-4 gap-4 p-2">
        <div class="col-span-2">
            <x-input type="text" readonly label="Producto" value="{{ $detalle->Product->name }}"/>
        </div>
        <x-input type="number" readonly label="Cantidad" readonly value="{{ $detalle->quantity }}" suffix="{{ $detalle->Product->MeasurementUnit->abbreviation }}"/>
        <x-input type="number" readonly label="Precio" value="{{ $detalle->price }}"/>
    </div>
    @endforeach
    @endif
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-button flat label="{{ __('Close') }}" x-on:click="close" />
            </div>
        </div>
    </x-slot>
</x-modal.card>
