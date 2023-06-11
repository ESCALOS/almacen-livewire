<div>
    <div>
        <div class="flex justify-between p-4">
            <div class="px-4 text-2xl font-black">
                <p class="font-bold">{{ $lastOrder ? 'Pedido del '.$fechaPedido : 'Pedido no abierto' }}</p>
            </div>
            <div>
                @if (!$lastOrder)
                    <x-button rounded positive label="Abrir Pedido" wire:click="abrirPedido"/>
                @else
                    <x-button rounded warning label="Extender pedido" wire:click="extenderPedido"/>
                    @if ($lastOrder->end && $lastOrder->end >= date('Y-m-d H:i:s'))
                        <x-button rounded negative label="Cerrar Pedido" wire:click="cerrarPedido"/>
                    @else
                        <x-button rounded positive label="Abrir Pedido" wire:click="abrirPedido"/>
                    @endif
                @endif
            </div>
        </div>
        <hr>
    </div>
</div>
