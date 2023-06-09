<div>
    <div class="flex justify-between p-4">
        <div class="text-2xl font-black px-4">
            <p class="font-bold">{{ $slot }}</p>
        </div>
        <div>
            <x-button rounded positive label="Registrar" wire:click="openModal()"/>
        </div>
    </div>
    <hr>
</div>