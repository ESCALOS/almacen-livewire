<x-modal.card title="Ingresar Productos" blur wire:model.defer="open">
    <div class="grid grid-cols-12 gap-4 px-4">
        @foreach ($products as $index => $product)
        <div class="grid grid-cols-3 col-span-10 gap-4 sm:col-span-11">
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
