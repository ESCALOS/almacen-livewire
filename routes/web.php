<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\MeasurementUnitController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\IncompletedPurchaseOrdersController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReasonController;
use App\Http\Controllers\Api\SolicitanteController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\WarehouseProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', [HomeController::class,'index']);
    Route::get('api/measurement-unit',[MeasurementUnitController::class,'__invoke'])->name('api.measurement-unit');
    Route::get('api/category',[CategoryController::class,'__invoke'])->name('api.category');
    Route::get('api/department',[DepartmentController::class,'__invoke'])->name('api.deparment');
    Route::get('api/product',[ProductController::class,'__invoke'])->name('api.product');
    Route::get('api/warehouse-product',[WarehouseProductController::class,'__invoke'])->name('api.warehouse-product');
    Route::get('api/warehouse',[WarehouseController::class,'__invoke'])->name('api.warehouse');
    Route::get('api/incompleted-purchase-orders',[IncompletedPurchaseOrdersController::class,'__invoke'])->name('api.incompleted-purchase-orders');
    Route::get('api/solicitante',[SolicitanteController::class,'__invoke'])->name('api.solicitante');
    Route::get('api/reason',[ReasonController::class,'__invoke'])->name('api.reason');
});
