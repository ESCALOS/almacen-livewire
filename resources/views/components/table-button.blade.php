<div>
    @if ($icon == 'pencil')
    <x-button rounded warning icon="pencil" wire:click="action({{ $id }})"/>
    @else
    <x-button rounded info icon="information-circle" wire:click="action({{ $id }})"/>
    @endif

</div>
