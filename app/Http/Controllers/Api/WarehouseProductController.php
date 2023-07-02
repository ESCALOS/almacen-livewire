<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WarehouseDetail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseProductController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return WarehouseDetail::query()
            ->join('products','products.id','warehouse_details.product_id')
            ->where('warehouse_details.warehouse_id',Auth::user()->Warehouse[0]->id)
            ->where('quantity','>',0)
            ->select('products.id','products.name')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('name','like',"%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()
            ->map(function (WarehouseDetail $warehouseDetail) {
                return $warehouseDetail;
            });
    }
}
