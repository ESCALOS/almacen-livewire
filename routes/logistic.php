<?php

use App\Http\Livewire\Logistic\Product\Base as Product;
use Illuminate\Support\Facades\Route;

Route::get('/productos',Product::class)->name('logistic.products');
