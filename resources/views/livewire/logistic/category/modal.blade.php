<x-modal.card title="{{ $categoryId ? 'Editar' : 'Registrar' }} Categoría" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-input label="Nombre" placeholder="Nombre de la Categoría" wire:model.defer='name'/>
        <x-input label="Descripción" placeholder="Descripcion de la Categoría" wire:model.defer='description'/>
    </div>
    <x-slot name="footer">
    <div class="flex justify-{{$categoryId ? 'between' : 'end'}} gap-x-4">
            @if($categoryId)
            <x-button flat negative label="{{ __('Delete') }}" wire:click="delete" />
            @endif
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>
