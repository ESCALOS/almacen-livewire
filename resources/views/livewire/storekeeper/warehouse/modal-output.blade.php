<x-modal.card title="Despachar Productos" blur wire:model.defer="open">


    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>

