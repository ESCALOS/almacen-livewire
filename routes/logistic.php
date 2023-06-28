<?php

use App\Http\Livewire\Logistic\Product\Base as Product;
use App\Http\Livewire\Logistic\Requirement\Base as Requirement;
use App\Http\Livewire\Logistic\PurchaseOrder\Base as PurchaseOrder;
use App\Http\Livewire\Logistic\Warehouse\Base as Warehouse;
use Illuminate\Support\Facades\Route;

Route::get('/productos',Product::class)->name('logistic.products');
Route::get('/requerimientos',Requirement::class)->name('logistic.requirements');
Route::get('/ordenes-de-compra',PurchaseOrder::class)->name('logistic.purchase-orders');
Route::get('/almacen',Warehouse::class)->name('logistic.warehouses');
