<?php

use App\Http\Livewire\Requester\Requirement\Base as Requeriment;
use Illuminate\Support\Facades\Route;

Route::get('/requerimientos',Requeriment::class)->name('requester.requirements');
