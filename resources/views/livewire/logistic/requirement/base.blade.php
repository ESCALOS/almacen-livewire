<div>
    <div class="flex justify-between p-4">
        <div class="px-4 text-2xl font-black">
            <p class="font-bold">{{ $title }}</p>
        </div>
        <div>
        @if ($closed)
            <x-button rounded positive label="Abrir" wire:click="openModal"/>
        @else
            <x-button rounded warning label="Modificar" wire:click="openModal"/>
            <x-button rounded negative label="Cerrar" wire:click="closeOrder"/>
        @endif
        </div>
    </div>
    <hr>
    <x-modal.card max-width="sm" title="{{ $orderDateId == 0 ? 'Abrir ' : 'Modificar' }} Pedido" blur wire:model.defer="open">
        <x-datetime-picker
            label="Fecha de cierre"
            placeholder="Indique la fecha de cierre"
            parse-format="YYYY-MM-DD HH:mm"
            wire:model="endDate"
            :min="today()"
        />
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
