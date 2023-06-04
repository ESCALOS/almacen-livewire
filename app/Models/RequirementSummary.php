<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementSummary extends Model
{
    use HasFactory;

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function OrderDate() {
        return $this->belongsTo(OrderDate::class);
    }
}
