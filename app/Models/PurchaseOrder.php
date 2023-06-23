<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function Currency(){
        return $this->belongsTo(Currency::class);
    }

    public function PurchaseOrderDetails(){
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function PartialPayments(){
        return $this->hasMany(PartialPayment::class);
    }
}
