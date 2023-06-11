<div>
    <div class="flex justify-between p-4">
        <div class="px-4 text-2xl font-black">
            <p class="font-bold">{{ $lastOrder ? 'Pedido del '.$fechaPedido : 'Pedido no abierto' }}</p>
        </div>
        <div>
            @if (!$lastOrder)
                <x-button rounded positive label="Abrir Pedido" wire:click="openModal"/>
            @else
                <x-button rounded warning label="Extender pedido" wire:click="openModal"/>
                @if ($lastOrder->end && $lastOrder->end >= date('Y-m-d H:i:s'))
                    <x-button rounded negative label="Cerrar Pedido" wire:click="close"/>
                @else
                    <x-button rounded positive label="Abrir Pedido" wire:click="openModal"/>
                @endif
            @endif
        </div>
    </div>
    <hr>
    <x-modal.card max-width="sm" title="{{ $orderDateId == 0 ? 'Abrir ' : 'Extender' }} Pedido" blur wire:model.defer="open">
        <x-datetime-picker
            label="Fecha de cierre"
            placeholder="Indique la fecha de cierre"
            parse-format="YYYY-MM-DD HH:mm"
            wire:model="endDate"
            :min="today()"
        />
        {{ $endDate }}
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <div class="flex">
                    <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                    <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
                </div>
            </div>
        </x-slot>
    </x-modal.card>
</div>
