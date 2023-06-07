<div class="w-full">
    <div class="grid items-center grid-cols-3 gap-4 p-6 bg-white">
        <x-button rounded positive label="Registrar" wire:click="openModal(0)"/>
        <x-button rounded warning label="Editar" wire:click="openModal(1)"/>
        <x-button rounded spinner='delete' negative label="Eliminar" wire:click='delete'/>
    </div>

    <div class="p-4 grid grid-cols-12 gap-4">
        <div class="col-span-12 sm:col-span-6">
            <x-input type="text" wire:model.lazy="search" placeholder="Escriba algo y presione enter para buscar"/>
        </div>
        <div class="col-span-6 sm:col-span-3">
            <x-select
                wire:model.defer="category"
                placeholder="Categoria"
                :async-data="route('api.category')"
                option-label="name"
                option-value="id"
            />
        </div>
        <div class="col-span-6 sm:col-span-3">
            <x-select
                wire:model.defer="measurementUnit"
                placeholder="Unidad de medida"
                :async-data="route('api.measurement-unit')"
                option-label="name"
                option-value="id"
            />
        </div>
    </div>
    @if ($products->count())
    <table class="w-full overflow-x-scroll table-fixed" wire:loading.remove wire:target='getProducts'>
        <thead>
            <tr class="text-sm leading-normal text-gray-600 uppercase bg-gray-200">
                <th class="py-3 text-center">
                    <span class="block">{{ __('Name') }}</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">{{ __('Description') }}</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">{{ __('Category') }}</span>
                </th>
                <th class="py-3 text-center">
                    <span class="block">{{ __('Measurement Unit') }}</span>
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
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $product->Category->name }}</span>
                        </div>
                    </td>
                    <td class="py-3 text-center">
                        <div>
                            <span class="font-medium">{{ $product->MeasurementUnit->name }}</span>
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
    @livewire('logistic.category.modal')
    @livewire('logistic.measurement-unit.modal')
</div>
