<div class="w-full">
    <x-header-crud>Lista de Productos</x-header-crud>
    <div class="p-4">
        <livewire:logistic.product.product-table>
    </div>
    @livewire('logistic.product.modal')
    @livewire('logistic.category.modal')
    @livewire('logistic.measurement-unit.modal')
</div>
