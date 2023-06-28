<x-modal.card title="{{ $productId ? 'Editar' : 'Registrar' }} Producto" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-input label="Nombre" placeholder="Nombre del Producto" wire:model.defer="name"/>
        <x-input label="Descripción" placeholder="Descripcion del Producto" wire:model.defer="description"/>

        <div class="grid grid-cols-12">
            <div class="col-span-10">
                <x-select
                    label="Categoria"
                    wire:model.defer="category"
                    placeholder="Seleccione una categoria"
                    :async-data="route('api.category')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <div class="col-span-2 mt-6 ml-3">
                <x-button.circle positive icon="plus" wire:click="$emitTo('logistic.category.modal','openModal',0)"/>
            </div>
        </div>

        <div class="grid grid-cols-12">
            <div class="col-span-10">
                <x-select
                    label="Unidad de Medida"
                    wire:model.defer="measurementUnit"
                    placeholder="Seleccione una unidad de medida"
                    :async-data="route('api.measurement-unit')"
                    option-label="name"
                    option-value="id"
                />
            </div>
            <div class="col-span-2 mt-6 ml-3">
                <x-button.circle positive icon="plus" wire:click="$emitTo('logistic.measurement-unit.modal','openModal',0)"/>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <div class="flex justify-{{$productId ? 'between' : 'end'}} gap-x-4">
            @if($productId)
            <x-button flat negative label="{{ __('Delete') }}" wire:click="delete" />
            @endif
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>
