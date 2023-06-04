<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementDetail extends Model
{
    use HasFactory;

    public function Product(){
        return $this->belongsTo(Product::class);
    }
    public function Requirement(){
        return $this->belongsTo(Requirement::class);
    }
}
