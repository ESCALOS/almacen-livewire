<div>
    @if ($liquidated)
        <x-badge rounded positive label="Liquidado" />
    @else
        @if ($credit)
        <div title="Amortizar">
            <x-button.circle warning icon="cash" wire:click="$emitTo('treasurer.purchase-order.amortize-modal','openModal',{{ $id }})"/>
        </div>
        @else
        <div title="Liquidar">
            <x-button.circle blue icon="check" wire:click="confirmLiquidate({{ $id }})"/>
        </div>
        @endif
    @endif
</div>
