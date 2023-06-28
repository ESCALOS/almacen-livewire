<x-modal.card title="Amortizar" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-input label="Cantidad Faltante" value="{{ $missingAmount }}" prefix="S/."/>
        <x-input label="Cantidad a Amortizar" wire:model.defer='amount' prefix="S/."/>
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
