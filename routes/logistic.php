<?php

use App\Http\Livewire\Logistic\OrderDate\Base as OrderDate;
use App\Http\Livewire\Logistic\Product\Base as Product;
use App\Http\Livewire\Logistic\Requirement\Base as Requirement;
use Illuminate\Support\Facades\Route;

Route::get('/productos',Product::class)->name('logistic.products');
Route::get('/fechas-de-pedido',OrderDate::class)->name('logistic.order-dates');
Route::get('/requerimientos',Requirement::class)->name('logistic.requirements');
