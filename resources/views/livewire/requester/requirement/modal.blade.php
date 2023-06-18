<x-modal.card title="Ingresar Productos" blur wire:model.defer="open">
    <div class="mt-6 text-center px-4 pb-4">
        <x-button positive icon="plus" label="Agregar Producto" wire:click='addProduct'/>
    </div>
    <hr>
    <div class="grid grid-cols-12 gap-4 p-4">
        @foreach ($products as $index => $product)
        <div class="grid grid-cols-3 col-span-11 gap-4">
            <x-select
                label="Producto"
                wire:model.defer="products.{{ $index }}.id"
                placeholder="Seleccione"
                :async-data="route('api.product')"
                option-label="name"
                option-value="id"
            />
            <x-input type="number" label="Cantidad" placeholder="Cantidad" wire:model.defer="products.{{ $index }}.quantity"/>
            <x-input type="number" label="Precio" placeholder="Costo" wire:model.defer="products.{{ $index }}.price"/>
        </div>
        <div class="mt-6">
            <x-button.circle negative icon="trash" wire:click='removeProduct({{ $index }})'/>
        </div>
        @endforeach
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
