<div class="w-full">
    <div class="flex justify-between p-4">
        <div class="text-2xl font-black px-4">
            <p class="font-bold">Lista de Productos</p>
        </div>
        <div>
            <x-button rounded positive label="Registrar" wire:click="openModal(0)"/>
        </div>
    </div>
    <hr>
    <div class="p-4">
        <livewire:logistic.product.product-table>
    </div>
    @livewire('logistic.product.modal')
    @livewire('logistic.category.modal')
    @livewire('logistic.measurement-unit.modal')
</div>
