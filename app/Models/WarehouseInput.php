<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseInput extends Model
{
    use HasFactory;

    public function WarehouseDepartment(){
        return $this->belongsTo(WarehouseDepartment::class);
    }

    public function PurchaseOrderDetail(){
        return $this->belongsTo(PurchaseOrderDetail::class);
    }
}
