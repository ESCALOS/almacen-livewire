<x-modal.card title="{{ $measurementUnitId == 0 ? 'Registrar' : 'Editar' }} Unidad de Medida" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-input label="Nombre" placeholder="Nombre" wire:model.defer='name'/>
        <x-input label="Abreviación" placeholder="Abreviaciòn" wire:model.defer='abbreviation'/>
    </div>
    <x-slot name="footer">
        <div class="flex justify-between gap-x-4">
            <x-button flat negative label="{{ __('Delete') }}" wire:click="delete" />

            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save" />
            </div>
        </div>
    </x-slot>
</x-modal.card>