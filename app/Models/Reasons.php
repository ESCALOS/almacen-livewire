<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reasons extends Model
{
    use HasFactory;

    public function WarehouseOutputs(){
        return $this->hasMany(WarehouseOutput::class);
    }
}
