<x-modal.card title="{{ $orderDateId == 0 ? 'Registrar' : 'Editar' }} Fecha de Pedido" blur wire:model.defer="open">
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    @if($orderDateId == 0)
    <x-datetime-picker
        label="Fecha inicial"
        placeholder="Fecha Inicial"
        parse-format="YYYY-MM-DD HH:mm"
        wire:model="startDate"
        :min="today()"
    />
    @else
    <x-datetime-picker
        label="Fecha inicial"
        placeholder="Fecha Inicial"
        parse-format="YYYY-MM-DD HH:mm"
        wire:model="startDate"
        disabled="disabled"
    />
    @endif
    <x-datetime-picker
        label="Fecha Final"
        placeholder="Fecha Final"
        parse-format="YYYY-MM-DD HH:mm"
        wire:model="endDate"
        :min="today()"
    />
    </div>
    <x-slot name="footer">
        <div class="flex justify-end gap-x-4">
            <div class="flex">
                <x-button flat label="{{ __('Cancel') }}" x-on:click="close" />
                <x-button primary spinner label="{{ __('Save') }}" wire:click="save"/>
            </div>
        </div>
    </x-slot>
</x-modal.card>