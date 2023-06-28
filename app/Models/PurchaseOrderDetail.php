<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function PurchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function WarehouseInputs(){
        return $this->hasMany(WarehouseInput::class);
    }
}
