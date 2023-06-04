<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    use HasFactory;

    public function Warehouse(){
        return $this->belongsTo(Warehouse::class);
    }

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function WarehouseDetails(){
        return $this->hasMany(WarehouseDetail::class);
    }
}
