<x-modal.card title="{{ $productId == 0 ? 'Registrar' : 'Editar' }} Producto" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-input label="Nombre" placeholder="Nombre del Producto" />
        <x-input label="Descripción" placeholder="Descripcion del Producto" />

        <div class="grid grid-cols-12 sm:grid-cols-6">
            <div class="col-span-10 sm:col-span-5">
                <x-select
                    label="Categoria"
                    wire:model.defer="category"
                    placeholder="Seleccione una categoria"
                    :async-data="route('api.category')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <div class="col-span-2 mt-6 ml-3 sm:col-span-1">
                <x-button.circle positive teal label="+" wire:click="$emitTo('logistic.category.modal','openModal',0)"/>
            </div>
        </div>

        <div class="grid grid-cols-12 sm:grid-cols-6">
            <div class="col-span-10 sm:col-span-5">
                <x-select
                    label="Unidad de Medida"
                    wire:model.defer="measurementUnit"
                    placeholder="Seleccione una unidad de medida"
                    :async-data="route('api.measurement-unit')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <div class="col-span-2 mt-6 ml-3 sm:col-span-1">
                <x-button.circle positive teal label="+" wire:click="$emitTo('logistic.category.modal','openModal',0)"/>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat negative label="{{ __('Delete') }}" wire:click="delete" />

            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary label="{{ __('Save') }}" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-modal.card>
