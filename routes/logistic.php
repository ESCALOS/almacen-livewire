<?php

use App\Http\Livewire\Logistic\Product\Base as Product;
use App\Http\Livewire\Logistic\Requirement\Base as Requirement;
use Illuminate\Support\Facades\Route;

Route::get('/productos',Product::class)->name('logistic.products');
Route::get('/requerimientos',Requirement::class)->name('logistic.requirements');
