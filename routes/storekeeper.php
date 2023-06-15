<?php
use App\Http\Livewire\Storekeeper\Warehouse\Base as Warehouse;
use Illuminate\Support\Facades\Route;


Route::get('/warehouse',Warehouse::class)->name('storekeeper.warehouse');