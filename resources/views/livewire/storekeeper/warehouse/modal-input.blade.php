<x-modal.card title="Ordenes de compra" blur wire:model.defer="open">
    <div class="px-4">
        <x-select
            label="Proveedor"
            wire:model="purchaseOrderId"
            placeholder="Seleccione un proveedor"
            :async-data="route('api.incompleted-purchase-orders')"
            option-label="name"
            option-value="id"
            option-description="ruc"
            clearable="true"
        />
    </div>
    <div wire:loading.remove class="grid grid-cols-3 gap-4 p-4">
        @foreach ($details as $index => $detail)
        <x-input label="Producto" value="{{ $detail['product'] }}"/>
        <x-input label="Cantidad" value="{{ $detail['quantity'] }}"/>
        <x-input label="Recibido" wire:model.defer="details.{{ $index }}.quantity_to_enter"/>
        @endforeach
    </div>
    <div wire:loading class="p-4">
        Cargando...
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>

