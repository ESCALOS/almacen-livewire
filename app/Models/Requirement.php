<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Department(){
        return $this->belongsTo(Department::class);
    }

    public function OrderDate() {
        return $this->belongsTo(OrderDate::class);
    }

    public function RequirementDetails() {
        return $this->belongsTo(RequirementDetail::class);
    }

    public function RequirementNewProducts() {
        return $this->belongsTo(RequirementNewProduct::class);
    }
}
