<div>
    <div class="flex justify-between p-4">
        <div class="px-4 text-2xl font-black">
            <p class="font-bold">{{ $slot }}</p>
        </div>
        <div>
            @if ($import)
            <x-button rounded cyan label="Importar" icon="upload" wire:click='openImportModal'/>
            @endif
            @if($button)
            <x-button rounded positive label="{{ $label }}" icon="plus" wire:click="{{ $action }}"/>
            @endif
        </div>
    </div>
    <hr>
</div>
