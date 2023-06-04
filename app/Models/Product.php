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
}
