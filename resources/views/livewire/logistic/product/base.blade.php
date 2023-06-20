<div class="w-full">
    <x-header-crud import="true">Lista de Productos</x-header-crud>
    <div class="p-4">
        <livewire:logistic.product.product-table>
    </div>
    <livewire:logistic.product.modal>
    <livewire:import-modal :model="$model" :columns="$columns">
    <livewire:logistic.category.modal>
    <livewire:logistic.measurement-unit.modal>
</div>
