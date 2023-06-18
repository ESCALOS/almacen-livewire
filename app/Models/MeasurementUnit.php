<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name','abbreviation'];

    public function Products(){
        return $this->hasMany(Product::class);
    }
}
