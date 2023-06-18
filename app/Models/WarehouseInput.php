<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseInput extends Model
{
    use HasFactory;

    public function WarehouseDetail(){
        return $this->belongsTo(WarehouseDetail::class);
    }

    public function PurchaseOrderDetail(){
        return $this->belongsTo(PurchaseOrderDetail::class);
    }
}
