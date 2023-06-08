<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function MeasurementUnit(){
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function WarehouseDetails(){
        return $this->hasMany(WarehouseDetail::class);
    }

    public function RequirementDetails(){
        return $this->hasMany(RequirementDetail::class);
    }

    public function RequirementSummaries(){
        return $this->hasMany(RequirementSummary::class);
    }
}
