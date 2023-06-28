<?php

use App\Http\Livewire\Treasurer\PurchaseOrder\Base as PurchaseOrder;
use Illuminate\Support\Facades\Route;

Route::get('/orden-de-compra',PurchaseOrder::class)->name('treasurer.purchase-orders');
