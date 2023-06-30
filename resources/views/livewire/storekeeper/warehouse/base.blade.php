<div class="w-full">
    @if ($warehouseId)
        <div class="flex justify-between p-4">
            <div class="px-4 text-2xl font-black">
                <p class="font-bold">Items</p>
            </div>
            <div>
                <x-button.circle lg title="Ingresar" rounded blue icon="login" wire:click="$emitTo('storekeeper.warehouse.modal-input','openModal')"/>
                <x-button.circle lg title="Despachar" rounded orange icon="logout" wire:click="$emitTo('storekeeper.warehouse.modal-output','openModal')"/>
            </div>
        </div>
        <hr>
        <div class="p-4">
            <livewire:storekeeper.warehouse.warehouse-detail-table :warehouseId="$warehouseId">
        </div>
        <livewire:storekeeper.warehouse.modal-input :warehouseId="$warehouseId">
        <livewire:storekeeper.warehouse.modal-output :warehouseId="$warehouseId">
    @else
        <div>
            Sin almacen asignado
        </div>
    @endif
</div>
