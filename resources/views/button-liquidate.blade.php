<div>
    @if ($liquidated)
        <x-badge rounded positive label="Liquidado" />
    @else
        @if ($credit)
            <x-button.circle title="Amortizar" warning icon="cash" wire:click="$emitTo('treasurer.purchase-order.amortize-modal','openModal',{{ $id }})"/>
        @else
            <x-button.circle title="Liquidar" blue icon="check" wire:click="confirmLiquidate({{ $id }})"/>
        @endif
    @endif
</div>
