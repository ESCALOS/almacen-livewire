@props(['title' => __('Confirm Password'), 'content' => __('For your security, please confirm your password to continue.'), 'button' => __('Confirm')])

@php
    $confirmableId = md5($attributes->wire('then'));
@endphp

<span
    {{ $attributes->wire('then') }}
    x-data
    x-ref="span"
    x-on:click="$wire.startConfirmingPassword('{{ $confirmableId }}')"
    x-on:password-confirmed.window="setTimeout(() => $event.detail.id === '{{ $confirmableId }}' && $refs.span.dispatchEvent(new CustomEvent('then', { bubbles: false })), 250);"
>
    {{ $slot }}
</span>

@once
<x-modal wire:model="confirmingPassword">
    <x-card title="{{ $title }}">
        {{ $content }}
        <div class="mt-4" x-data="{}" x-on:confirming-password.window="setTimeout(() => $refs.confirmable_password.focus(), 250)">
            <x-input type="password" class="block w-3/4 mt-1" placeholder="{{ __('Password') }}" autocomplete="current-password"
                        x-ref="confirmable_password"
                        wire:model.defer="confirmablePassword"
                        wire:keydown.enter="confirmPassword" />

            <x-input-error for="confirmable_password" class="mt-2" />
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="{{__('Cancel') }}" x-on:click="close" wire:click="stopConfirmingPassword" wire:loading.attr="disabled"/>
                <x-button primary label="{{ $button }}" dusk="confirm-password-button" wire:click="confirmPassword" wire:loading.attr="disabled"/>
            </div>
        </x-slot>
    </x-card>
</x-modal>
@endonce
