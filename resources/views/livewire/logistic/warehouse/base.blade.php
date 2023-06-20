<div class="w-full">
    <x-header-crud import="true">
        <x-select
            label="Almacen"
            wire:model="warehouseId"
            placeholder="Seleccione"
            :async-data="route('api.warehouse')"
            option-label="name"
            option-value="id"
        />
    </x-header-crud>
    <div class="p-4">
        <livewire:logistic.warehouse.warehouse-detail-table :warehouseId="$warehouseId">
    </div>
    <livewire:logistic.warehouse.modal>
    <livewire:import-modal :model="$model" :columns="$columns">
</div>
