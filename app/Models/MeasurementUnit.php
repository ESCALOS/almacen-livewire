<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;

    public function Products(){
        return $this->hasMany(Product::class);
    }

    public function RequirementNewProducts(){
        return $this->hasMany(RequirementNewProduct::class);
    }
}
