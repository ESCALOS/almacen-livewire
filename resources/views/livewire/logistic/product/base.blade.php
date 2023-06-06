<div class="w-full">
    <div class="grid items-center grid-cols-3 gap-4 p-6 bg-white">
        <x-button rounded positive label="Registrar" wire:click="$emitTo('product.modal','abrirModal',0)"/>
        <x-button rounded warning label="Editar" wire:click="$emitTo('product.modal','abrirModal',{{$productId}})"/>
        <x-button rounded negative label="Eliminar" wire:click='delete'/>
    </div>

    <div class="py-2" style="padding-left: 1rem; padding-right:1rem">
        <x-input type="text" style="height:40px;width: 100%" wire:model.lazy="search" placeholder="Escriba algo y presione enter para buscar"/>
    </div>
    @if ($products->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getProducts'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">{{ __('Name') }}</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">{{ __('Price') }}</span>
                </th>
            </tr>
        </thead>
        <tbody class="text-sm font-light text-gray-600">
            @foreach ($products as $product)
                <tr style="cursor:pointer" wire:click="seleccionar({{$product->id}})" class="border-b {{ $product->id == $productId ? 'bg-blue-200' : '' }} border-gray-200">
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $product->description }}</span>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-4 py-4" wire:loading.remove wire:target='getProducts'>
        {{ $products->links() }}
    </div>
    @else
    <div class="px-6 py-4 text-2xl font-black" wire:loading.remove wire:target='getProducts'>
        Ningún registro coincidente
    </div>
    @endif
    <div style="align-items:center;justify-content:center;margin-bottom:15px" wire:loading.flex wire:target='getProducts'>
        <div class="text-center">
            <h1 class="text-4xl font-bold">
                CARGANDO DATOS...
            </h1>
        </div>
    </div>
    @livewire('logistic.product.modal')
</div>
