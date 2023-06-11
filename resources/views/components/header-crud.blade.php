<div>
    <div class="flex justify-between p-4">
        <div class="px-4 text-2xl font-black">
            <p class="font-bold">{{ $slot }}</p>
        </div>
        <div>
            <x-button rounded positive label="{{ $label }}" wire:click="{{ $action }}"/>
        </div>
    </div>
    <hr>
</div>
