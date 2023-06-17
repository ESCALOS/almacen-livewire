<div class="w-full">
    @if ($warehouseId > 0)
        <x-header-crud label="Ingresar Productos">Lista de Productos</x-header-crud>
        <div class="p-4">
            <livewire:storekeeper.warehouse.warehouse-detail-table>
        </div>
        <livewire:storekeeper.warehouse.modal :warehouseId="$warehouseId">
    @else
        <div>
            Sin almacen asignado
        </div>
    @endif

</div>
