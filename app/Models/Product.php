<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'measurement_unit_id', 'category_id'];

    public function Category(){
        return $this->belongsTo(Category::class);
    }

    public function MeasurementUnit(){
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function WarehouseDetails(){
        return $this->hasMany(WarehouseDetail::class);
    }

    public function Requirements(){
        return $this->hasMany(Requirement::class);
    }
}
