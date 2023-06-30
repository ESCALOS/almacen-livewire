<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IncompletedPurchaseOrdersController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        return PurchaseOrder::query()
            ->join('suppliers','suppliers.id','purchase_orders.supplier_id')
            ->select('purchase_orders.id','suppliers.name','suppliers.ruc')
            ->orderBy('name')
            ->when(
                $request->search,
                fn (Builder $query) => $query
                    ->where('suppliers.name','like',"%{$request->search}%")
            )
            ->when(
                $request->exists('selected'),
                fn (Builder $query) => $query->whereIn('purchase_orders.id', $request->input('selected', [])),
                fn (Builder $query) => $query->limit(10)
            )
            ->get()
            ->map(function (PurchaseOrder $purchaseOrder) {
                return $purchaseOrder;
            });
    }
}
