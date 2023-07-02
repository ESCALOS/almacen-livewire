<x-modal.card title="Despachar Productos" blur wire:model.defer="open">
    <div class="px-4 grid grid-cols-2 gap-4">
        <x-select
            label="Solicitante"
            wire:model.defer="userId"
            placeholder="Seleccione un solicitante"
            :async-data="route('api.solicitante')"
            option-label="name"
            option-value="id"
            option-description="department"
            :template="[
                'name'   => 'user-option',
                'config' => ['src' => 'profile_photo_url']
            ]"
        />
        <x-select
            label="Motivo"
            wire:model.defer="reasonId"
            placeholder="Seleccione un motivo"
            :async-data="route('api.reason')"
            option-label="name"
            option-value="id"
        />
    </div>
    <hr class="my-4">
    <div class="grid grid-cols-12 gap-4 px-4">
        @foreach ($products as $index => $product)
        <div class="grid grid-cols-4 col-span-10 gap-4 sm:col-span-11">
            <div class="col-span-2">
                <x-select
                    label="Producto"
                    wire:model="products.{{ $index }}.id"
                    placeholder="Seleccione"
                    :async-data="route('api.warehouse-product')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <x-input type="number" readonly label="Stock" wire:model.defer="products.{{ $index }}.quantity"/>
            <x-input type="number" label="Despachado" wire:model.defer="products.{{ $index }}.quantity_to_leave"/>
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

