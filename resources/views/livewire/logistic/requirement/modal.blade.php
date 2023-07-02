<x-modal.card title="Ingresar Productos" blur wire:model.defer="open">
    <div class="grid grid-cols-2 gap-4 px-4 pb-4">
        <x-input type="number" label="RUC" max="20999999999" wire:model.lazy='supplierRuc'/>
        <x-input type="text" readonly label="Proveedor" value="{{ $supplierName }}"/>
        <x-input type="text" readonly label="Dirección" value="{{ $supplierAddress }}"/>
        <div class="grid grid-cols-2 gap-4" style="justify-items: center; align-content:center">
            <x-radio lg left-label="CONTADO" wire:model.defer='paymentMethod' value="0" id="paymentMethod"/>
            <x-radio lg left-label="CRÉDITO" wire:model.defer='paymentMethod' value="1" id="paymentMethod"/>
        </div>
    </div>
    <hr>
    <div class="grid grid-cols-12 gap-4 p-4">
        @foreach ($products as $index => $product)
        <div class="grid grid-cols-4 col-span-10 gap-4 sm:col-span-11">
            <div class="col-span-2">
                <x-select
                    label="Producto"
                    wire:model.defer="products.{{ $index }}.id"
                    placeholder="Seleccione"
                    :async-data="route('api.product')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <x-input type="number" label="Cantidad" wire:model.defer="products.{{ $index }}.quantity"/>
            <x-input type="number" label="Precio" wire:model.defer="products.{{ $index }}.price"/>
        </div>
        <div class="col-span-2 mt-6 sm:col-span-1">
            <x-button.circle negative icon="trash" wire:click='removeProduct({{ $index }})'/>
        </div>
        @endforeach
    </div>

    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button positive icon="plus" wire:click='addProduct'/>
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>
