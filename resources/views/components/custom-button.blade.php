<div class="p-{{ $padding }} @if($colspan != 1)col-span-{{$colspan}}@endif @if($colspan != $colspansm)sm:col-span-{{$colspansm}}@endif">
    <button type="button" wire:click='{{  $accion  }}' class="w-full inline-flex items-center justify-center px-4 py-2 bg-{{$color}}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{$color}}-500 focus:outline-none focus:border-{{$color}}-700 focus:ring focus:ring-{{$color}}-200 active:bg-{{$color}}-600 disabled:opacity-25 transition" {{ $activo ? "" : "disabled" }}>
        {{ $slot }}
    </button>
</div>
