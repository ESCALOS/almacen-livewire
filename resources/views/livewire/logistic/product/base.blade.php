<div class="w-full">
    <x-header-crud import="true">Lista de Productos</x-header-crud>
    <div class="p-4">
        <livewire:logistic.product.product-table>
    </div>
    <x-modal.card title="Importar Productos" blur wire:model.defer="openImport">
        <x-input label="Archivo" placeholder="Ingrese el archivo" type="file" wire:model.defer="archivo"/>
        <x-slot name="footer">
            <div class="flex justify-between gap-x-4">
                <div>
                    <x-button positive label="Exportar Formato" sm icon="download" wire:click='exportFormat'/>
                </div>
                <div class="flex">
                    <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                    <x-button primary spinner label="{{ __('Save') }}" wire:click="import"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
    @livewire('logistic.product.modal')
    @livewire('logistic.category.modal')
    @livewire('logistic.measurement-unit.modal')
</div>
