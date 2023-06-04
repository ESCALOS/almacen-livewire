<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementNewProduct extends Model
{
    use HasFactory;

    public function MeasurementUnit(){
        return $this->belongsTo(MeasurementUnit::class);
    }

    public function Requirement(){
        return $this->belongsTo(Requirement::class);
    }
}
